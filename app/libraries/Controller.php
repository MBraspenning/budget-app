<?php

/*
*
* Base Controller
* Loads models and views
*
*/

class Controller
{
    // Load Model
    public function model($model)
    {
        // Require model file
        require_once '../src/Model/' . $model . '.php';
        
        // Instantiate model
        return new $model();
    }
    
    // Load View
    public function view($view, $data = [])
    {
        // Check for view file
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die('View does not exist');
        }
    }
}