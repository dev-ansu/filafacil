<?php

setlocale(LC_TIME, 'pt_BR');
ini_set('default_charset', 'utf-8');
session_name(md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']));
session_start();
date_default_timezone_set('America/Fortaleza');
header("Access-Control-Allow-Origin: *");

require "dompdf/autoload.inc.php";
require 'app/core/Core.php';
require  "config/config.php";
require  "config/constants.php";
require "vendor/autoload.php";


use app\core\Core;
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('ACCEPTED_LOCALS', '*');

$core = new Core;

try{
    $addr = $_SERVER['REMOTE_ADDR'];
    if((is_array(ACCEPTED_LOCALS) && in_array($addr, ACCEPTED_LOCALS)) || ACCEPTED_LOCALS == '*'){
        $core->run();
    }else{
        echo '<h1><b>500 Internal Server Error</b></h1>';   
        die;
    }
}catch(Exception $e){
    echo $e;
}


