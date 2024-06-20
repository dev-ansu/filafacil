<?php

namespace app\services;

use app\models\UserCargo;

class UserCargoService{

    protected $model;

    function __construct()
    {
        $this->model = new UserCargo;        
    }

    public function create($data){
        try{
            $create = $this->model->insert($data);
            if($create){
                return true;
            }
            return false;
        }catch(\Exception $e){
            setFlash('message', FAILED_CREATE_MESSAGE);
            back();
        }
    }

    public function all($fields = [], $where = '', $data = [], $groupBy = '', $orderBy = '', $limit = '', $join = ''){
        return $this->model->fetchAll($fields, $where, $data, $groupBy, $orderBy, $limit, $join);
    }

    public function one(array $fields = [], $where = '', $data = [], $groupBy = '', $orderBy = '', $limit = '', $join =''){
        return $this->model->fetch($fields, $where, $data, $groupBy, $orderBy, $limit, $join);
    }

}