<?php

class DefaultController extends Controller
{
    public function __construct()
    {
        // Redirect if not logged in
        if (!isset($_SESSION['user_id']) && !BYPASS_AUTH) {
            redirect('login');    
        }
        
        $this->incomeModel = $this->model('Income');
    }
    
    public function indexAction()
    {        
        $this->view('home');
    }
    
    public function archiveAction()
    {
        $fetchAll = $this->incomeModel->getAllIncome();
        $years = [];
        
        foreach($fetchAll as $el) {
            $years[] = substr($el->added_date, 0, 4);
        }
        $yearsUnique = array_unique($years);
        
        $this->view('archive', array(
            'yearsUnique' => $yearsUnique
        ));
    }
}