<?php
ini_set('display_errors', 0);
session_start();

define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/Autoload.php');


$router = new Router();
$router->run();
