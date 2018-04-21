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
    
    public function registerUser(array $register_input)
    {
        $password_hash = password_hash($register_input['password'], PASSWORD_DEFAULT);
        
        $this->db->query("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");
        
        $this->db->bind(':username', $register_input['username']);
        $this->db->bind(':password', $password_hash);
        $this->db->bind(':email', $register_input['email']);
        
        $this->db->executeStmt();
    }
    
    public function loginUser(array $login_input)
    {        
        $this->db->query("SELECT * FROM users WHERE email = :email");        
        $this->db->bind(':email', $login_input['email']);        
        
        $user = $this->db->single();
        
        $password_hash = $user->password;
        
        if (password_verify($login_input['password'], $password_hash)) {
            return $user;    
        } else {
            return false;
        }                      
    }
}