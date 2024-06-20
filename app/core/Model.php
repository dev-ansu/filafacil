<?php

namespace app\core;

use PDO;
use PDOException;
use app\core\Database;

abstract class Model extends Database{
    
    protected $pdo = "";

    public function __construct(string $db){

        $database = method_exists($this, $db) ? $this->$db():"ouro";

        if(!$db){
            echo "O banco de dados é obrigatório";
        }        
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