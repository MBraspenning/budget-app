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
}