<?php

class Budget
{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }
    
    public function getAllBudget()
    {
        $this->db->query("SELECT * FROM budget");
        
        $results = $this->db->resultSet();
        
        return $results;
    }
    
    public function getAllBudgetForMonth(int $M, int $Y)
    {
        $this->db->query("SELECT * FROM budget WHERE month = :month AND year = :year ORDER BY id DESC LIMIT 1");
        
        $this->db->bind(':month', $M);
        $this->db->bind(':year', $Y);
        
        $results = $this->db->resultSet();
        
        return $results;
    }
    
    public function getBudgetMonth()
    {
        $this->db->query("SELECT month FROM budget ORDER BY id DESC LIMIT 1");
        $budgetMonth = $this->db->single();
        
        return $budgetMonth;
    }
    
    public function newBudget(int $M, int $Y, $amount, $type)
    {
        $this->db->query("INSERT INTO budget (month, year, total_" . $type . ", total_budget) VALUES (:month, :year, :total_inc_exp, :total_budget)");    

        $this->db->bind(':month', $M);
        $this->db->bind(':year', $Y);
        $this->db->bind(':total_inc_exp', $amount);
        
        $new_total_budget;
        if ($type === 'income') {
            $new_total_budget = $amount;
        }
        if ($type === 'expense') {
            $new_total_budget = 0.00 - $amount;
        }
        
        $this->db->bind(':total_budget', $new_total_budget);
        
        $this->db->executeStmt();
    }
    
    public function updateBudget(int $amount, string $type, string $action)
    {
        if ($type === 'income') {
            if ($action === 'insert' || $action === 'edit') {
                $this->db->query("UPDATE budget SET total_income = total_income + :amount, total_budget = total_income - total_expense ORDER BY id DESC LIMIT 1"); 
                $this->db->bind(':amount', $amount);
                $this->db->executeStmt();    
            }
            if ($action === 'delete') {
                $this->db->query('UPDATE budget SET total_income = total_income - :amount, total_budget = total_income - total_expense ORDER BY id DESC LIMIT 1');
                $this->db->bind(':amount', $amount);
                $this->db->executeStmt();
            }
        }
        if ($type === 'expense') {
            if ($action === 'insert' || $action === 'edit') {
                $this->db->query("UPDATE budget SET total_expense = total_expense + :amount, total_budget = total_income - total_expense ORDER BY id DESC LIMIT 1");
                $this->db->bind(':amount', $amount);
                $this->db->executeStmt();    
            }  
            if ($action === 'delete') {
                $this->db->query('UPDATE budget SET total_expense = total_expense - :amount, total_budget = total_income - total_expense ORDER BY id DESC LIMIT 1');
                $this->db->bind(':amount', $amount);
                $this->db->executeStmt();
            }
        } 
    }
}