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
        $allBudgetForCurrentMonth = $this->budgetModel->getAllBudgetForCurrentMonth();
        $allIncomeForCurrentMonth = $this->incomeModel->getAllIncomeForCurrentMonth();
        $allExpenseForCurrentMonth = $this->expenseModel->getAllExpenseForCurrentMonth();
        
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
                    $this->budgetModel->updateBudget($_POST['amount'], 'income');
                } else {
                    $this->budgetModel->newBudget($currentMonth, $currentYear, $_POST['amount'], 'income');
                }        
            }
            
            if ($_POST['select-type'] === 'select-expense') {
                
                $this->expenseModel->insertExpense($_POST['description'], $_POST['amount']);
                
                if (intval($budgetMonth->month) === $currentMonth) {
                    $this->budgetModel->updateBudget($_POST['amount'], 'expense');
                } else {
                    $this->budgetModel->newBudget($currentMonth, $currentYear, $_POST['amount'], 'expense');
                } 
            }
        }
    }
}