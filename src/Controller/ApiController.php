<?php

use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->incomeModel = $this->model('Income');
        $this->expenseModel = $this->model('Expense');
        $this->budgetModel = $this->model('Budget');
    }
    
    public function verifyAccessToken()
    {
        $headers = apache_request_headers();
        
        $authorization_header = $headers['Authorization'];
                
        $jwt = null;
        
        if (preg_match('/Bearer\s(\S+)/', $authorization_header, $matches)) 
        {
            $jwt = $matches[1];
        }
        
        try 
        {
            $decoded = JWT::decode($jwt, JWT_KEY, array('HS512'));  
            
            return $decoded->data;            
        }
        catch (ExpiredException $e)
        {
            throw $e;
        }                   
    }
    
    public function loginAction()
    {               
        $request = file_get_contents('php://input');
        
        $data = json_decode($request);        
            
        $user_login_input = [
            'email' => trim($data->email),
            'password' => trim($data->password)
        ];

        $validationErrors = $this->userModel->validateLogin($user_login_input);

        if (empty($validationErrors))
        {
            $user = $this->userModel->loginUser($user_login_input);
            
            if ($user) 
            {                
                $key = JWT_KEY;

                $issuedAt = time();
                $issuer = URLROOT;
                $notBefore = $issuedAt;
                $expires = $notBefore + (30);

                $token = array(
                    'iat' => $issuedAt,
                    'iss' => $issuer,
                    'nbf' => $notBefore,
                    'exp' => $expires,
                    'data' => [
                        'userId' => $user->id
                    ]
                );
                
                $jwt = JWT::encode($token, $key, 'HS512');
                
                echo json_encode(['access_token' => $jwt]);
            } 
            else 
            {
                echo json_encode(['error' => 'invalid username or password']);
            }   
        }
        else 
        {
            echo json_encode(['error' => 'invalid username or password']);
        }                     
    }
    
    public function fetchAction()
    {   
        try 
        {
            $client_data = $this->verifyAccessToken(); 
            
            $month = intval(date('n'));
            $year = intval(date('Y'));

            $user_id = $client_data->userId;

            $allBudgetForCurrentMonth = $this->budgetModel->getAllBudgetForMonth($month, $year, $user_id);
            $allIncomeForCurrentMonth = $this->incomeModel->getAllIncomeForMonth($month, $year, $user_id);
            $allExpenseForCurrentMonth = $this->expenseModel->getAllExpenseForMonth($month, $year, $user_id);

            $budgetJSON = json_encode($allBudgetForCurrentMonth);
            $incomeJSON = json_encode($allIncomeForCurrentMonth);
            $expenseJSON = json_encode($allExpenseForCurrentMonth);

            $jsonArr = [$budgetJSON, $incomeJSON, $expenseJSON];

            echo json_encode($jsonArr);
        }
        catch (ExpiredException $e)
        {
            header('HTTP/1.1 401 Unauthorized');
        } 
    }
    
    public function insertAction()
    {
        try
        {
            $client_data = $this->verifyAccessToken();
            $user_id = $client_data->userId;
            
            $request = file_get_contents('php://input');
        
            $data = json_decode($request);

            $currentMonth = intval(date('n'));
            $currentYear = intval(date('Y'));
            $budgetMonth = $this->budgetModel->getBudgetMonth($user_id);                

            if ($data->type === 'income') {

                $this->incomeModel->insertIncome($data->description, $data->amount, $user_id);

                if (intval($budgetMonth->month) === $currentMonth) {
                    $this->budgetModel->updateBudget($data->amount, 'income', 'insert', $user_id);
                } else {
                    $this->budgetModel->newBudget($currentMonth, $currentYear, $data->amount, 'income', $user_id);
                }        
            }

            if ($data->type === 'expense') {

                $this->expenseModel->insertExpense($data->description, $data->amount, $user_id);

                if (intval($budgetMonth->month) === $currentMonth) {
                    $this->budgetModel->updateBudget($data->amount, 'expense', 'insert', $user_id);
                } else {
                    $this->budgetModel->newBudget($currentMonth, $currentYear, $data->amount, 'expense', $user_id);
                } 
            }    
        }
        catch (ExpiredException $e)
        {
            header('HTTP/1.1 401 Unauthorized');
        }
    }
    
    public function editAction()
    {
        try
        {
            $client_data = $this->verifyAccessToken();
            $user_id = $client_data->userId;
            
            $request = file_get_contents('php://input');
        
            $data = json_decode($request);

            if ($data->type === 'income') {
                $currentAmount = $this->incomeModel->getAmountForOneResult($data->id);
                $updateTotalIncomeAmount = intval($data->amount) - intval($currentAmount->amount);

                $this->incomeModel->editIncome($data->description, $data->amount, $data->id);

                $this->budgetModel->updateBudget($updateTotalIncomeAmount, 'income', 'edit', $user_id);
            }

            if ($data->type === 'expense') {
                $currentAmount = $this->expenseModel->getAmountForOneResult($data->id);
                $updateTotalExpenseAmount = intval($data->amount) - intval($currentAmount->amount);

                $this->expenseModel->editExpense($data->description, $data->amount, $data->id);

                $this->budgetModel->updateBudget($updateTotalExpenseAmount, 'expense', 'edit', $user_id);
            }    
        }
        catch (ExpiredException $e)
        {
            header('HTTP/1.1 401 Unauthorized');
        }
    }
    
    public function deleteAction()
    {
        try
        {
            $client_data = $this->verifyAccessToken();
            $user_id = $client_data->userId;
            
            $request = file_get_contents('php://input');
        
            $data = json_decode($request);

            if ($data->type === 'income') {
                $this->incomeModel->deleteIncome($data->id);
                $this->budgetModel->updateBudget($data->amount, $data->type, 'delete', $user_id);
            }
            if ($data->type === 'expense') {
                $this->expenseModel->deleteExpense($data->id);
                $this->budgetModel->updateBudget($data->amount, $data->type, 'delete', $user_id);
            }    
        }
        catch (ExpiredException $e)
        {
            header('HTTP/1.1 401 Unauthorized');
        }
    }        
}