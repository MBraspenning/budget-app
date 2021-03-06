<?php

class AjaxController extends Controller
{
    public function __construct()
    {
        // Redirect if not logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('login');    
        }
        
        $this->incomeModel = $this->model('Income');
        $this->expenseModel = $this->model('Expense');
        $this->budgetModel = $this->model('Budget');
    }
    
    public function fetchAction()
    {
        $month;
        $year;
        
        if (isset($_GET['month']) && isset($_GET['year'])) 
        {
            $month = $_GET['month'];
            $year = $_GET['year'];
        } 
        else 
        {
            $month = intval(date('n'));
            $year = intval(date('Y'));
        }
        
        $user_id = $_SESSION['user_id'];
        
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
        $currentMonth = intval(date('n'));
        $currentYear = intval(date('Y'));
        $budgetMonth = $this->budgetModel->getBudgetMonth($_SESSION['user_id']);
        
        if (isset($_POST['submit'])) {
            if ($_POST['select-type'] === 'select-income') {
                
                $this->incomeModel->insertIncome($_POST['description'], $_POST['amount'], $_SESSION['user_id']);
                
                if (intval($budgetMonth->month) === $currentMonth) {
                    $this->budgetModel->updateBudget($_POST['amount'], 'income', 'insert', $_SESSION['user_id']);
                } else {
                    $this->budgetModel->newBudget($currentMonth, $currentYear, $_POST['amount'], 'income', $_SESSION['user_id']);
                }        
            }
            
            if ($_POST['select-type'] === 'select-expense') {
                
                $this->expenseModel->insertExpense($_POST['description'], $_POST['amount'], $_SESSION['user_id']);
                
                if (intval($budgetMonth->month) === $currentMonth) {
                    $this->budgetModel->updateBudget($_POST['amount'], 'expense', 'insert', $_SESSION['user_id']);
                } else {
                    $this->budgetModel->newBudget($currentMonth, $currentYear, $_POST['amount'], 'expense', $_SESSION['user_id']);
                } 
            }
        }
    }
    
    public function editAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {            
            if ($_GET['type'] === 'income') {
                $currentAmount = $this->incomeModel->getAmountForOneResult($_GET['id']);
                $updateTotalIncomeAmount = intval($_GET['amount']) - intval($currentAmount->amount);
                
                $this->incomeModel->editIncome($_GET['description'], $_GET['amount'], $_GET['id']);
                                
                $this->budgetModel->updateBudget($updateTotalIncomeAmount, 'income', 'edit', $_SESSION['user_id']);
            }
            
            if ($_GET['type'] === 'expense') {
                $currentAmount = $this->expenseModel->getAmountForOneResult($_GET['id']);
                $updateTotalExpenseAmount = intval($_GET['amount']) - intval($currentAmount->amount);
                
                $this->expenseModel->editExpense($_GET['description'], $_GET['amount'], $_GET['id']);
                            
                $this->budgetModel->updateBudget($updateTotalExpenseAmount, 'expense', 'edit', $_SESSION['user_id']);
            }
        }
    }
    
    public function deleteAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            if ($_GET['type'] === 'income') {
                $this->incomeModel->deleteIncome($_GET['id']);
                $this->budgetModel->updateBudget($_GET['amount'], $_GET['type'], 'delete', $_SESSION['user_id']);
            }
            if ($_GET['type'] === 'expense') {
                $this->expenseModel->deleteExpense($_GET['id']);
                $this->budgetModel->updateBudget($_GET['amount'], $_GET['type'], 'delete', $_SESSION['user_id']);
            }
        }
    }
}