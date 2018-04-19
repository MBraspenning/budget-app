<?php

class UserController extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }
    
    public function registerAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $user_input = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password'])
            ];
            
            $validationErrors = $this->userModel->validateInput($user_input);
            
            if (empty($validationErrors)) {
                $this->userModel->registerUser($user_input);
                redirect('user/login');
            } else {
                $this->view('users/register', array(
                    'errors' => $validationErrors
                ));
            }
                        
        } else {                        
            $this->view('users/register', array(
                'errors' => [],
            ));
        }
    }
    
    public function loginAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_error' => '',
                'password_error' => '',                
            ];
            
            $this->view('users/login', $data);
        }
    }
}
