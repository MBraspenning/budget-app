<?php
    
// Load Config
require_once 'config/config.php';

// Load Necessary Files
spl_autoload_register(function($classname)
{
    require 'libraries/' . $classname . '.php';
});
