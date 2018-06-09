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
}