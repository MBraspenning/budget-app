<?php

class Income
{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }
    
    public function getAllIncome()
    {
        $this->db->query("SELECT * FROM income WHERE user_id = :user_id");
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $results = $this->db->resultSet();
        
        return $results;
    }
    
    public function getAllIncomeForMonth(int $M, int $Y, string $user_id)
    {
        $this->db->query("SELECT * FROM income 
            WHERE MONTH(added_date) = :month 
            AND YEAR(added_date) = :year 
            AND user_id = :user_id");
                
        $this->db->bind(':month', $M);
        $this->db->bind(':year', $Y);
        $this->db->bind(':user_id', $user_id);
        
        $results = $this->db->resultSet();
        
        return $results;
    }
    
    public function getAmountForOneResult(int $id)
    {
        $this->db->query("SELECT amount FROM income WHERE id = :id");
        $this->db->bind(':id', $id);
        
        $result = $this->db->single();
        
        return $result;
    }
    
    public function insertIncome(string $inc_description, int $amount, string $user_id)
    {
        $now = date('Y-m-d');
        
        $this->db->query("INSERT INTO income (user_id, income, amount, added_date) VALUES (:user_id, :income, :amount, :added_date)");
        
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':income', $inc_description);
        $this->db->bind(':amount', $amount);
        $this->db->bind(':added_date', $now);
        
        $this->db->executeStmt();
    }
    
    public function editIncome(string $description, int $amount, int $id)
    {
        $this->db->query("UPDATE income SET income = :description, amount = :amount WHERE id = :id");
        
        $this->db->bind(':description', $description);
        $this->db->bind(':amount', $amount);
        $this->db->bind(':id', $id);
        
        $this->db->executeStmt();
    }
    
    public function deleteIncome(int $id)
    {
        $this->db->query("DELETE FROM income WHERE id = :id");
        
        $this->db->bind(':id', $id);
        
        $this->db->executeStmt();
    }
}