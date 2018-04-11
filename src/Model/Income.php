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
        $this->db->query("SELECT * FROM income");
        
        $results = $this->db->resultSet();
        
        return $results;
    }
    
    public function getAllIncomeForCurrentMonth()
    {
        $month = intval(date('n'));
        $year = intval(date('Y'));
        $this->db->query("SELECT * FROM income WHERE MONTH(added_date) = :month AND YEAR(added_date) = :year");
        
        $this->db->bind(':month', $month);
        $this->db->bind(':year', $year);
        
        $results = $this->db->resultSet();
        
        return $results;
    }
}