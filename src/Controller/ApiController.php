<?php

class ApiController extends Controller
{
    public function __construct()
    {
        $this->incomeModel = $this->model('Income');
        $this->expenseModel = $this->model('Expense');
        $this->budgetModel = $this->model('Budget');
    }
    
    public function fetchAction()
    {
        $month = intval(date('n'));
        $year = intval(date('Y'));
        
        $user_id = $_GET['user_id'];
        
        $allBudgetForCurrentMonth = $this->budgetModel->getAllBudgetForMonth($month, $year, $user_id);
        $allIncomeForCurrentMonth = $this->incomeModel->getAllIncomeForMonth($month, $year, $user_id);
        $allExpenseForCurrentMonth = $this->expenseModel->getAllExpenseForMonth($month, $year, $user_id);
                
        $budgetJSON = json_encode($allBudgetForCurrentMonth);
        $incomeJSON = json_encode($allIncomeForCurrentMonth);
        $expenseJSON = json_encode($allExpenseForCurrentMonth);
        
        $jsonArr = [$budgetJSON, $incomeJSON, $expenseJSON];

        echo json_encode($jsonArr);
    }
    
    public function insertAction()
    {
        $request = file_get_contents('php://input');
        
        $data = json_decode($request);
        
        $currentMonth = intval(date('n'));
        $currentYear = intval(date('Y'));
        $budgetMonth = $this->budgetModel->getBudgetMonth($data->user_id);                
        
        if ($data->type === 'income') {

            $this->incomeModel->insertIncome($data->description, $data->amount, $data->user_id);

            if (intval($budgetMonth->month) === $currentMonth) {
                $this->budgetModel->updateBudget($data->amount, 'income', 'insert', $data->user_id);
            } else {
                $this->budgetModel->newBudget($currentMonth, $currentYear, $data->amount, 'income', $data->user_id);
            }        
        }

        if ($data->type === 'expense') {

            $this->expenseModel->insertExpense($data->description, $data->amount, $data->user_id);

            if (intval($budgetMonth->month) === $currentMonth) {
                $this->budgetModel->updateBudget($data->amount, 'expense', 'insert', $data->user_id);
            } else {
                $this->budgetModel->newBudget($currentMonth, $currentYear, $data->amount, 'expense', $data->user_id);
            } 
        }        
    }
    
    public function editAction()
    {
        $request = file_get_contents('php://input');
        
        $data = json_decode($request);
        
        if ($data->type === 'income') {
            $currentAmount = $this->incomeModel->getAmountForOneResult($data->id);
            $updateTotalIncomeAmount = intval($data->amount) - intval($currentAmount->amount);

            $this->incomeModel->editIncome($data->description, $data->amount, $data->id);

            $this->budgetModel->updateBudget($updateTotalIncomeAmount, 'income', 'edit', $data->user_id);
        }

        if ($data->type === 'expense') {
            $currentAmount = $this->expenseModel->getAmountForOneResult($data->id);
            $updateTotalExpenseAmount = intval($data->amount) - intval($currentAmount->amount);

            $this->expenseModel->editExpense($data->description, $data->amount, $data->id);

            $this->budgetModel->updateBudget($updateTotalExpenseAmount, 'expense', 'edit', $data->user_id);
        }
    }
    
    public function deleteAction()
    {
        $request = file_get_contents('php://input');
        
        $data = json_decode($request);
        
        if ($data->type === 'income') {
            $this->incomeModel->deleteIncome($data->id);
            $this->budgetModel->updateBudget($data->amount, $data->type, 'delete', $data->user_id);
        }
        if ($data->type === 'expense') {
            $this->expenseModel->deleteExpense($data->id);
            $this->budgetModel->updateBudget($data->amount, $data->type, 'delete', $data->user_id);
        }
    }
}