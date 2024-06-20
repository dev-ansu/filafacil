<?php

namespace app\services;
use app\models\PreviousGeneratedPass;


class PreviousGeneratedPassService{

    protected $model;

    function __construct()
    {
        $this->model = new PreviousGeneratedPass;        
    }

    public function create($data){
        $create = $this->model->insert($data);

        if($create){
            return $data;
        }else{
            return false;
        }
    }

    public function all($fields = [], $where = '', $data = [], $groupBy = '', $orderBy = '', $limit = '', $join = ''){
        return $this->model->fetchAll($fields, $where, $data, $groupBy, $orderBy, $limit, $join);
    }

    public function one(array $fields = [], $where = '', $data = [], $groupBy = '', $orderBy = '', $limit = '', $join =''){
        return $this->model->fetch($fields, $where, $data, $groupBy, $orderBy, $limit, $join);
    }

}