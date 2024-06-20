<?php

namespace app\models;
use app\core\Model;

class DAO extends Model{

    protected $table;
    protected $fields;
    protected $data;
    protected $conditions;
    protected $operator;
    
    public function __construct(string $db = "ouro", string $table = '', string $fields = "*",  array $data = [], array $conditions = [], string $operator = ''){
        parent::__construct($db);
        $this->table = $table;
        $this->fields = $fields;
        $this->data = $data;
        $this->conditions = $conditions;
        $this->operator = $operator;

    }

    public function fetchAll(string $order = "", string $group = "", string $limit = ""){
        $sql = "SELECT {$this->fields} FROM {$this->table}";
        if($this->conditions){
            $sql.= " WHERE ";
            foreach($this->conditions as $key => $condition){
                $sql.= " {$key} {$condition}  -{$this->operator}-";
            }
        }
        
        $sql = rtrim($sql, "-{$this->operator}-");
        if(str_contains($sql, "-{$this->operator}-")){
            $expleded = explode("-", $this->operator);
            $sql= str_replace("-{$this->operator}-", $expleded[0], $sql);
        }
        // return $sql;
        $sql .= $group ? " GROUP BY {$group} ":"";
        $sql .= $order ? " ORDER BY {$order} ":"";
        $sql .= $limit ? " LIMIT {$limit}":"";
        $prepare = $this->pdo->prepare($sql);
        $prepare->execute($this->data);
        return $prepare->fetchAll();
    }

    public function fetch(string $order = "", string $group = "", string $limit = ""){
        $sql = "SELECT {$this->fields} FROM {$this->table}";
        if($this->conditions){
            $sql.= " WHERE ";
            foreach($this->conditions as $key => $condition){
                $sql.= $key . " " . $condition . " " . $this->operator . " ";
            }
        }
       
        $sql = rtrim($sql, " {$this->operator} ");
        $sql .= $order ? " ORDER BY {$order} ":"";
        $sql .= $group ? " GROUP BY {$group} ":"";
        $sql .= $limit ? " LIMIT {$limit}":"";

        $prepare = $this->pdo->prepare($sql);
        $prepare->execute($this->data);

        return $prepare->fetch();
    }

    public function delete(){
        $sql = "DELETE FROM {$this->table}";
        if($this->conditions){
            $sql.= " WHERE ";
            foreach($this->conditions as $key => $condition){
                $sql.= $key . $condition . " " . $this->operator;
            }
        }
        $sql = rtrim($sql, "{$this->operator}");
        $prepare = $this->pdo->prepare($sql);
        $prepare->execute($this->data);
        return $prepare->rowCount();
    }
    
    public function update($toIgnore = [], $limit = '', array $removeFromData = []){
        $sql = "UPDATE {$this->table} SET ";
        foreach($this->data as $key => $valor){
            if(!in_array($key, $toIgnore)){
                $sql.= " $key = :" . $key . ", ";
            }else{
                if(in_array($key, $removeFromData)){
                    unset($this->data[$key]);
                }
            }
        }
        $sql = rtrim($sql, ", ");
        if($this->conditions){
            $sql.= " WHERE ";
            foreach($this->conditions as $key => $condition){
                $sql.= " " . $key . $condition . " " . $this->operator;
            }
        }
        $sql = rtrim($sql, "{$this->operator}");
        $sql .= $limit ? " LIMIT {$limit}":"";
        $prepare = $this->pdo->prepare($sql);
        $prepare->execute($this->data);
        return $prepare->rowCount();
    }

    public function insert(){
        $sql = "INSERT INTO $this->table(";
        foreach($this->data as $key => $valor){
            $sql.= $key. ", ";
        }
        $sql = rtrim($sql, ", ");
        $sql.=") VALUES(";
        foreach($this->data as $key => $valor){
            $sql.= ":".$key. ", ";
        }
        $sql = rtrim($sql, ", ");
        $sql.=")";
        $prepare = $this->pdo->prepare($sql);
        $prepare->execute($this->data);
        if($this->pdo->lastInsertId()){
            return $this->pdo->lastInsertId();
        }else{
            return $prepare->rowCount();
        }
    }

}