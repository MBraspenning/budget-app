<?php
    
// Load Config
require_once 'config/config.php';

// Load Necessary Files
//require_once 'AppCore.php';
//require_once '../src/Controller/Base/Controller.php';
//require_once 'Database.php';

spl_autoload_register(function($classname)
{
    require 'libraries/' . $classname . '.php';
});
