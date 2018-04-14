<?php

class Expense
{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }
    
    public function getAllExpense()
    {
        $this->db->query("SELECT * FROM expense");
        
        $results = $this->db->resultSet();
        
        return $results;
    }
    
    public function getAllExpenseForMonth(int $M, int $Y)
    {
        $this->db->query("SELECT * FROM expense WHERE MONTH(added_date) = :month AND YEAR(added_date) = :year");
        
        $this->db->bind(':month', $M);
        $this->db->bind(':year', $Y);
        
        $results = $this->db->resultSet();
        
        return $results;
    }
    
    public function getAmountForOneResult(int $id)
    {
        $this->db->query("SELECT amount FROM expense WHERE id = :id");
        $this->db->bind(':id', $id);
        
        $result = $this->db->single();
        
        return $result;
    }
    
    public function insertExpense(string $exp_description, int $amount)
    {
        $now = date('Y-m-d');
        
        $this->db->query("INSERT INTO expense (expense, amount, added_date) VALUES (:expense, :amount, :added_date)");
        
        $this->db->bind(':expense', $exp_description);
        $this->db->bind(':amount', $amount);
        $this->db->bind(':added_date', $now);
        
        $this->db->executeStmt();
    }
    
    public function editExpense(string $description, int $amount, int $id)
    {
        $this->db->query("UPDATE expense SET expense = :description, amount = :amount WHERE id = :id");
        
        $this->db->bind(':description', $description);
        $this->db->bind(':amount', $amount);
        $this->db->bind(':id', $id);
        
        $this->db->executeStmt();
    }
    
    public function deleteExpense(int $id)
    {
        $this->db->query("DELETE FROM expense WHERE id = :id");
        
        $this->db->bind(':id', $id);
        
        $this->db->executeStmt();
    }
}