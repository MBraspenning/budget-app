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
    
    public function getAllExpenseForCurrentMonth()
    {
        $month = intval(date('n'));
        $year = intval(date('Y'));
        $this->db->query("SELECT * FROM expense WHERE MONTH(added_date) = :month AND YEAR(added_date) = :year");
        
        $this->db->bind(':month', $month);
        $this->db->bind(':year', $year);
        
        $results = $this->db->resultSet();
        
        return $results;
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
}