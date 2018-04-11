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
    
    public function getAllBudgetForCurrentMonth()
    {
        $month = intval(date('n'));
        $year = intval(date('Y'));
        $this->db->query("SELECT * FROM budget WHERE month = :month AND year = :year ORDER BY id DESC LIMIT 1");
        
        $this->db->bind(':month', $month);
        $this->db->bind(':year', $year);
        
        $results = $this->db->resultSet();
        
        return $results;
    }
}