<?php

class DefaultController extends Controller
{
    public function __construct()
    {
        $this->incomeModel = $this->model('Income');
    }
    
    public function indexAction()
    {
        $income = $this->incomeModel->getAllIncome();
        
        $this->view('home', array(
            'income' => $income
        ));
    }
    
    public function archiveAction()
    {
        $this->view('archive');
    }
}