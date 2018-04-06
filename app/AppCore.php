<?php

/*
*
* App Core Class
* Creates URL & Loads Core Controller
* URL FORMAT - /controller/method/params
*
*/

class AppCore
{
    protected $currentController = 'Default';
    protected $currentMethod = 'index';
    protected $params = [];
    
    public function __construct()
    {
        // print_r($this->getUrl());
        $url = $this->getUrl();
        
        // Look in controllers for first value
        if (file_exists('../src/Controller/'. ucfirst($url[0]) .'Controller.php')) {
            $this->currentController = ucfirst($url[0]);
            unset($url[0]);
        }
    }
    
    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
