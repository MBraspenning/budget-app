<?php

class UserController extends Controller
{
    public function __construct()
    {
        
    }
    
    public function registerAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        } else {
            $data = [
                'username' => 'Matthijs',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'username_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => ''
            ];
            
            $this->view('users/register', $data);
        }
    }
}
