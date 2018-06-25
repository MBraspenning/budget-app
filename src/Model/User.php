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
        
        // VALIDATE FIELDS ARE APPROPRIATE LENGTH / FORMAT
        if 
        (
            !empty($data['username']) &&
            (
                strlen($data['username']) < 2 || 
                strlen($data['username']) > 15 || 
                !ctype_alnum($data['username'])
            )
        ) 
        {
            $errors['username_error'] = 
                'Username must be between 2 and 15 characters long and can only contain alphanumeric (a-z, A-Z, 0-9) characters.';
        }
        
        if
        (
            !empty($data['password']) &&
            (
                strlen($data['password']) < 6 ||
                preg_match("/^.*(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $data['password']) === 0
            )
        )
        {
            $errors['password_error'] =
                'Password must be at least 6 characters long and contain at least a lowercase and an uppercase character and one digit.';
        }
        
        // VALIDATE EMAIL FORMAT
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email_error'] = 'Please enter a valid email.';
        }
        
        // CHECK IF USER EMAIL IS ALREADY TAKEN
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $data['email']);
        $row = $this->db->single();
        
        if ($this->db->countAllRows() > 0) {
            $errors['email_error'] = 'This email is already used. Already have an account?';
        }
                    
        // VALIDATE PASSWORD MATCHES CONFIRM PASSWORD
        if 
        (
            !empty($data['password']) && 
            !empty($data['confirm_password']) && 
            $data['password'] !== $data['confirm_password']
        ) 
        {
            $errors['password_error'] = 
                'Passwords don\'t match.';
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
    
    public function validateLogin(array $data) : array
    {
        $errors = [];
        
        // VALIDATE FIELDS ARE NOT EMPTY
        if (empty($data['login'])) {
            $errors['login_error'] = 'Please enter your username or email.';
        }
        if (empty($data['password'])) {
            $errors['password_error'] = 'Please enter your password.';
        }
        
        // VALIDATE CORRECT EMAIL / PASSWORD
        if (!empty($data['login'])) {
            $this->db->query("SELECT email, password FROM users WHERE email = :login OR username = :login");
            $this->db->bind(':login', $data['login']);
            
            $row = $this->db->single();
            
            if ($this->db->countAllRows() === 0) {
                $errors['login_error'] = 'Incorrect username or email.';
            }
            
            if (!empty($data['password']) && $this->db->countAllRows() > 0 && !password_verify($data['password'], $row->password)) {
                $errors['password_error'] = 'Incorrect password.';
            }
        }
        
        return $errors;
    }
    
    public function loginUser(array $login_input)
    {        
        $this->db->query("SELECT * FROM users WHERE email = :login OR username = :login");        
        $this->db->bind(':login', $login_input['login']);        
        
        $user = $this->db->single();
        
        if ($user) {
            $password_hash = $user->password;    
            
            if (password_verify($login_input['password'], $password_hash)) {
                return $user;    
            } else {
                return 'false';
            }
        } else {
            return false;
        }
    }
}