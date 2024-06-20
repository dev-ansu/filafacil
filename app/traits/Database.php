<?php

namespace app\traits;
use PDO;
use PDOException;

trait Database{
    
    protected $pdo = null;

    public function db(){
        $db = [
            "HOST" =>   $_ENV['HOST'],
            "DBNAME" => $_ENV['DBNAME'],
            "USER" =>   $_ENV['USER'],
            "PASS" =>   $_ENV['PASS'],
            "PORT" =>   $_ENV['PORT'],
        ];
        $this->connect($db);
        return $this;
    }

    private function connect($database){
        if(!$this->pdo){
            try{
                $this->pdo = new PDO(DB_DRIVER.":"."host={$database['HOST']};dbname={$database['DBNAME']};charset=utf8mb4;port={$database['PORT']}", $database['USER'], $database['PASS'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_INIT_COMMAND =>"SET NAMES utf8",
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]);
            }catch(PDOException $e){
                echo "A conexão com o banco de dados não foi estabelecida. <br>
                {$e->getMessage()}
                ";
            }
        }
    }

}