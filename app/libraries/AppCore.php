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
    protected $currentController = 'DefaultController';
    protected $currentMethod = 'indexAction';
    protected $params = [];
    
    public function __construct()
    {      
        $url = $this->getUrl();

        // Look in controllers for first value
        if (file_exists('../src/Controller/'.ucfirst($url[0]).'Controller.php')) {
            $this->currentController = ucfirst($url[0]).'Controller';
            unset($url[0]);            
        }
        
        // Require the controller
        require_once '../src/Controller/'.$this->currentController.'.php';
        
        // Instantiate controller
        $this->currentController = new $this->currentController;

        if (get_class($this->currentController) === 'DefaultController' && !is_null($url[0])) {
            $this->currentMethod = $url[0] . 'Action';
        }
        
        // Check for second part of url
        if (isset($url[1])) {
            // Check if method exists
            if (method_exists($this->currentController, $url[1].'Action')) {
                $this->currentMethod = $url[1] . 'Action';
                unset($url[1]);
            }
        } 
        
        // Check for third part of url
        $this->params = $url ? array_values($url) : [];
        
        // Callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
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
