<?php

class UserController extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }
    
    public function registerAction()
    {
        if (isLoggedIn()) {
            redirect('');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $user_register_input = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password'])
            ];
            
            $validationErrors = $this->userModel->validateInput($user_register_input);
            
            if (empty($validationErrors)) {
                $this->userModel->registerUser($user_register_input);
                redirect('login');
            } else {
                $this->view('users/register', array(
                    'user_register_input' => $user_register_input,
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
        if (isLoggedIn()) {
            redirect('');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $user_login_input = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password'])
            ];
            
            $validationErrors = $this->userModel->validateLogin($user_login_input);
            
            if (empty($validationErrors)) {
                $user = $this->userModel->loginUser($user_login_input);
                if ($user) {
                    $this->setUserSession($user);
                    redirect('');    
                } else {
                    $this->view('users/login', array(
                        'user_login_input' => $user_login_input,
                        'errors' => $validationErrors,
                    ));    
                }   
            } else {
                $this->view('users/login', array(
                    'user_login_input' => $user_login_input,
                    'errors' => $validationErrors,
                ));    
            }  
            
        } else {            
            $this->view('users/login', array(
                'errors' => [],
            ));
        }
    }
    
    public function logoutAction()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_username']);
        unset($_SESSION['user_email']);
        session_destroy();
        redirect('login');
    }
    
    public function setUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_username'] = $user->username;
        $_SESSION['user_email'] = $user->email;
    }
}
