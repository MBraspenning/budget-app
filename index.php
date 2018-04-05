<?php

$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

switch ($request_uri[0]) {
    case '/':
        require 'views/home.php';
        break;
    case '/index.php':
        require 'views/home.php';
        break;
    case '/index':
        require 'views/home.php';
        break;
    case '/archive':
        require 'views/archive.php';
        break;
}
