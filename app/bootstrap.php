<?php
    
// Load Config
require_once 'config/config.php';

// Load Helpers
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';
require_once 'helpers/flash_helper.php';

// Load Necessary Files
spl_autoload_register(function($classname)
{
    require 'libraries/' . $classname . '.php';
});
