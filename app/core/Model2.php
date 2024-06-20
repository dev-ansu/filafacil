<?php

namespace app\core;
use app\traits\Database;
use app\classes\Validate;
use PDO;

abstract class Model2{

    use Database;

    protected $table = 'users';
    protected $fillable = [];
    private $data;

    private function getFields($fields){
        if(!$fields && (is_array($fields) && count($fields) <= 0)){
            $this->fillable = implode(",", $this->fillable);
        }else{
            if(is_array($fields)){
                $this->fillable = implode(",", $fields);
            }else{
                throw new \Excpetion('Error of fillable');
            }
        }
        return $this->fillable;
    }
    
    public function update($data, $removeFromData = [], $where){
        $sql = "UPDATE $this->table SET ";
        foreach($data as $key => $valor){
            if(!in_array($key, $removeFromData)){
                $sql.= " $key = :" . $key . ", ";
            }
        }
        $sql = rtrim($sql, ", ");
        if(trim($where)){
            $sql.= " WHERE $where";
        }else{
            throw new \Exception("Cláusula where não informada");
            die();
        }
        $prepare = $this->pdo->prepare($sql);
            $prepare->execute($data);
        return $prepare->rowCount();
    }

    /**
     * 
     */
    public function fetchAll(array $fields = [], $where = '', $data = [], $groupBy = '', $orderBy = '', $limit = '', $join =''){
        $sql = "SELECT {$this->getFields($fields)}";
        if($join){
            $sql.= " FROM {$this->table} $join ";
        }else{
            $sql.= " FROM {$this->table}";
        }
        $sql.= trim($where) ? " WHERE $where":"";
        $sql.= trim($groupBy) ? " GROUP BY $groupBy":"";
        $sql.= trim($orderBy) ? " ORDER BY $orderBy":"";
        $sql.= trim($limit) ? " LIMIT $limit":"";
        $prepare = $this->pdo->prepare($sql);
        if($data){
            foreach($data as $key => $value){
                if(str_contains($key, ",")){
                    [$key, $param] = explode(",", $key);
                    $prepare->bindValue(":".$key, $value, constant($param));
                }else{
                    $prepare->bindValue(":".$key, $value);
                }
            }
            $prepare->execute();
        }else{
            $prepare->execute();
        }
        $this->data = $prepare->fetchAll();
        return [
            'count' => count($this->data),
            'data' => $this->data,
        ];
    }

    public function fetch(array $fields = [], $where = '', $data = [], $groupBy = '', $orderBy = '', $limit = '', $join =''){
        $sql = "SELECT {$this->getFields($fields)}";
        if($join){
            $sql.= " FROM {$this->table} $join ";
        }else{
            $sql.= " FROM {$this->table}";
        }
        $sql.= trim($where) ? " WHERE $where":"";
        $sql.= trim($groupBy) ? " GROUP BY $groupBy":"";
        $sql.= trim($orderBy) ? " ORDER BY $orderBy":"";
        $sql.= trim($limit) ? " LIMIT $limit":"";
        $prepare = $this->pdo->prepare($sql);
        if($data){
            foreach($data as $key => $value){
                if(str_contains($key, ",")){
                    [$key, $param] = explode(",", $key);
                    $prepare->bindValue(":".$key, $value, constant($param));
                }else{
                    $prepare->bindValue(":".$key, $value);
                }
            }
            $prepare->execute();
        }else{
            $prepare->execute();
        }
        $this->data = $prepare->fetch();
        return $this->data;          
    }

    public function insert(array $data){
        $sql = "INSERT INTO $this->table(";
        foreach($data as $key => $valor){
            $sql.= $key. ", ";
        }
        $sql = rtrim($sql, ", ");
        $sql.=") VALUES(";
        foreach($data as $key => $valor){
            $sql.= ":".$key. ", ";
        }
        $sql = rtrim($sql, ", ");
        $sql.=")";
        $prepare = $this->pdo->prepare($sql);
        $prepare->execute($data);
        if($this->pdo->lastInsertId()){
            return $this->pdo->lastInsertId();
        }
        return $prepare->rowCount();
    }

    public function delete($where, $data){
        $sql = "DELETE FROM $this->table";
        if(!$where || !$data){
            throw new \Exception('Este método só pode ser executada com uma cláusula WHERE');
            exit;
        }
        $sql.= " WHERE $where";
        $prepare = $this->pdo->prepare($sql);
        $prepare->execute($data);
        return $prepare->rowCount();
    }

    public function paginate(array $fields = [], $limit = 10){
        $page = (new Validate)->validate(
            [
                'page' => 'optional',
                'search' => 'optional',
            ]
            );

        if(!$page){
            $page = 1;
            $inicio = 0;
        }else{
            extract($page);
        }

        $limit = $limit > 0 ? $limit:10;

        if($page <= 0){
            $page = 1;
            $initial = 0;
        }else{
            $initial = (intval($page) * $limit) - $limit;  
        }

        $sql = "SELECT 
            {$this->getFields($fields)} 
            FROM {$this->table}
        ";
        $prepare = $this->pdo->prepare($sql);


        if($search){
            $sql.= " WHERE NOME LIKE :NOME";
            $prepare = $this->pdo->prepare($sql);
            $prepare->execute(
                ['NOME' => "%$search%"]
            );
        }else{
            $prepare->execute();
        }
        
        $this->data = $prepare->fetchAll();

        $data = array_slice($this->data, $initial, $limit);

        $this->data = [
            'count' => count($this->data),
            'initial' => $initial,
            'limit' => $limit,
            'page' => $page,
            'data' => $data,
        ];

        return $this;
    }

    public function get(){
        return $this->data;
    }

}