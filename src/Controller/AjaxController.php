<?php

class AjaxController extends Controller
{
    public function __construct()
    {
        $this->incomeModel = $this->model('Income');
        $this->expenseModel = $this->model('Expense');
        $this->budgetModel = $this->model('Budget');
    }
    
    public function fetchAction()
    {
        $month;
        $year;
        if (isset($_GET['month']) && isset($_GET['year'])) {
            $month = $_GET['month'];
            $year = $_GET['year'];
        } else {
            $month = intval(date('n'));
            $year = intval(date('Y'));
        }
        
        $allBudgetForCurrentMonth = $this->budgetModel->getAllBudgetForMonth($month, $year);
        $allIncomeForCurrentMonth = $this->incomeModel->getAllIncomeForMonth($month, $year);
        $allExpenseForCurrentMonth = $this->expenseModel->getAllExpenseForMonth($month, $year);
        
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
        $budgetMonth = $this->budgetModel->getBudgetMonth();
        
        if (isset($_POST['submit'])) {
            if ($_POST['select-type'] === 'select-income') {
                
                $this->incomeModel->insertIncome($_POST['description'], $_POST['amount']);
                
                if (intval($budgetMonth->month) === $currentMonth) {
                    $this->budgetModel->updateBudget($_POST['amount'], 'income', 'insert');
                } else {
                    $this->budgetModel->newBudget($currentMonth, $currentYear, $_POST['amount'], 'income');
                }        
            }
            
            if ($_POST['select-type'] === 'select-expense') {
                
                $this->expenseModel->insertExpense($_POST['description'], $_POST['amount']);
                
                if (intval($budgetMonth->month) === $currentMonth) {
                    $this->budgetModel->updateBudget($_POST['amount'], 'expense', 'insert');
                } else {
                    $this->budgetModel->newBudget($currentMonth, $currentYear, $_POST['amount'], 'expense');
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
                                
                $this->budgetModel->updateBudget($updateTotalIncomeAmount, 'income', 'edit');
            }
            
            if ($_GET['type'] === 'expense') {
                $currentAmount = $this->expenseModel->getAmountForOneResult($_GET['id']);
                $updateTotalExpenseAmount = intval($_GET['amount']) - intval($currentAmount->amount);
                
                $this->expenseModel->editExpense($_GET['description'], $_GET['amount'], $_GET['id']);
                            
                $this->budgetModel->updateBudget($updateTotalExpenseAmount, 'expense', 'edit');
            }
        }
    }
    
    public function deleteAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            if ($_GET['type'] === 'income') {
                $this->incomeModel->deleteIncome($_GET['id']);
                $this->budgetModel->updateBudget($_GET['amount'], $_GET['type'], 'delete');
            }
            if ($_GET['type'] === 'expense') {
                $this->expenseModel->deleteExpense($_GET['id']);
                $this->budgetModel->updateBudget($_GET['amount'], $_GET['type'], 'delete');
            }
        }
    }
}