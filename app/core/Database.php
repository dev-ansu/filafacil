<?php
namespace app\core;

use app\interfaces\InterfaceDatabase;

abstract class Database implements InterfaceDatabase{
    public function db_config(){
        return [
            "HOST" =>   $_ENV['HOST'],
            "DBNAME" => $_ENV['DBNAME'],
            "USER" =>   $_ENV['USER'],
            "PASS" =>   $_ENV['PASS'],
            "PORT" =>   $_ENV['PORT'],
        ];
    }

    public function ouro(){
        return [
            "HOST" =>   'servidorouro',
            "DBNAME" => 'ouromoderno',
            "USER" =>   'prepara2',
            "PASS" =>   'prepara',
            "PORT" =>   '3306',
        ];
    }
}