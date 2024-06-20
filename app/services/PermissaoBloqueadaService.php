<?php

namespace app\services;

use app\models\Cargos;
use app\models\PermissaoBloqueada;

class PermissaoBloqueadaService{

    protected $model;

    function __construct()
    {
        $this->model = new PermissaoBloqueada;        
    }

    public function create($data){
        try{
            $create = $this->model->insert($data);
            if($create){
                setFlash('message', SUCCESS_CREATE_MESSAGE, 'success');
                back();
            }else{
                setFlash('message', FAILED_CREATE_MESSAGE);
                back();
            }
        }catch(\Exception $e){
            setFlash('message', FAILED_CREATE_MESSAGE);
            back();
        }
    }

    public function update($data=[], $ignore = [],  $where){
        return $this->model->update($data, $ignore, $where);
    }

    public function all($fields = [], $where = '', $data = [], $groupBy = '', $orderBy = '', $limit = '', $join = ''){
        return $this->model->fetchAll($fields, $where, $data, $groupBy, $orderBy, $limit, $join);
    }

    public function one(array $fields = [], $where = '', $data = [], $groupBy = '', $orderBy = '', $limit = '', $join =''){
        return $this->model->fetch($fields, $where, $data, $groupBy, $orderBy, $limit, $join);
    }

}