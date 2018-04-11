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
}