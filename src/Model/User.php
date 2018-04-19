<?php

class User
{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }
    
    public function validateInput(array $data) : array
    {
        $errors = [];
        
        if (empty($data['username'])) {
            $errors['username_error'] = 'Username cannot be empty.';
        }
                
        return $errors;
    }
    
    public function registerUser(array $data)
    {
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $this->db->query("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");
        
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $password);
        $this->db->bind(':email', $data['email']);
        
        $this->db->executeStmt();
    }
    
    
}