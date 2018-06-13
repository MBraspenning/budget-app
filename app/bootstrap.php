<?php
    
// Load Config
require_once 'config/config.php';

// Load Helpers
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';
require_once 'helpers/flash_helper.php';

// Load Composer Autoload
require_once '../vendor/autoload.php';

// Load Necessary Files
spl_autoload_register(function($classname)
{
    if (file_exists(__DIR__ . '/libraries/' . $classname . '.php'))
    {
        require __DIR__ . '/libraries/' . $classname . '.php';
    }
});
