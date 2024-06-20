<?php

define("HOST", "localhost");
define("DBNAME", "pizzaria");
define("USER", "root");
define("PASS", "");
define("PORT", "");

define("CLIENT_ZAP_SERVER_NAME","@c.us");
define("COUNTRY_CODE",'55');
define('CONTROLLER_PADRAO', 'home');
define('METODO_PADRAO', 'index');
define('NAMESPACE_CONTROLLER', 'app\\controllers\\');
define("PASTA_PADRAO", "app/controllers/");
define('URL_BASE', 'http://pc-1/filafacil/');
define("PATH_COMPONENTS", $_SERVER['DOCUMENT_ROOT']."/filafacil/app/views/components/");
define("SESSION_LOGIN", "session_fila_facil");
define("SESSION_OWNER_LOGIN", "owner");
define("NOT_FOUND_MESSAGE", "404 - PÁGINA NÃO ENCONTRADA");
define("UPLOAD_DIR", $_SERVER["DOCUMENT_ROOT"]."/aurosoft/assets/uploads/");
define('ROOT', dirname(__FILE__, 2));
define('DB_DRIVER', 'mysql');
define("SECRET_KEY", "4Gh#9qP2z$6vJ@5x");

define('DAYS',[
    'Mon' => 1,
    'Tue' => 2,
    'Wed' => 3,
    'Thu' => 4,
    'Fri' => 5,
    'Sat' => 6,
    'Sun' => 7,
    'Sun' => 0
]);

define('MONTHS_NAME',
array(
    'Jan' => 'Janeiro',
    'Feb' => 'Fevereiro',
    'Mar' => 'Marco',
    'Apr' => 'Abril',
    'May' => 'Maio',
    'Jun' => 'Junho',
    'Jul' => 'Julho',
    'Aug' => 'Agosto',
    'Nov' => 'Novembro',
    'Sep' => 'Setembro',
    'Oct' => 'Outubro',
    'Dec' => 'Dezembro'
));
define('DAYS_NAME',[
    '1' => 'Segunda-feira',
    '2' => 'Terça-feira',
    '3' => 'Quarta-feira',
    '4' => 'Quinta-feira',
    '5' => 'Sexta-feira',
    '6' => 'Sábado',
    '0' => 'Domingo',
    '7' => 'Domingo',
]);



