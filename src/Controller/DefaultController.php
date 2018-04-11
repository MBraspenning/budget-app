<?php

class DefaultController extends Controller
{
    public function __construct()
    {
        $this->incomeModel = $this->model('Income');
    }
    
    public function indexAction()
    {        
        $this->view('home');
    }
    
    public function archiveAction()
    {
        $this->view('archive');
    }
}