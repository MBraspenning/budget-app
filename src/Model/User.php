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
        
        // CHECK IF USER EMAIL IS ALREADY TAKEN
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $data['email']);
        $row = $this->db->single();
        
        if ($this->db->countAllRows() > 0) {
            $errors['email_error'] = 'This email is already used. Already have an account?';
        } 
        
        // VALIDATE FIELDS ARE NOT EMPTY
        if (empty($data['username'])) {
            $errors['username_error'] = 'Username cannot be empty.';
        }
        if (empty($data['email'])) {
            $errors['email_error'] = 'Email cannot be empty.';
        }
        if (empty($data['password'])) {
            $errors['password_error'] = 'Password cannot be empty.';
        }
        if (empty($data['confirm_password'])) {
            $errors['confirm_password_error'] = 'Please confirm your password.';
        }
        
        // VALIDATE EMAIL FORMAT
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email_error'] = 'Please enter a valid email.';
        }
        
        // VALIDATE PASSWORD MATCHES CONFIRM PASSWORD
        if 
        (
            !empty($data['password']) && 
            !empty($data['confirm_password']) && 
            $data['password'] !== $data['confirm_password']
        ) {
            $errors['password_error'] = 
                'Passwords don\'t match, please verify you entered the correct password.';
            $errors['confirm_password_error'] = 
                'Passwords don\'t match, please verify you entered the correct password.';
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