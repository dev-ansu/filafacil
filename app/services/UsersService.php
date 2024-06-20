<?php

namespace app\services;
use app\models\Users;

class UsersService{

    protected $model;

    function __construct()
    {
        $this->model = new Users;        
    }

    private function hashPassword($pass){
        if(!$pass){
            throw new \Exception('A senha não foi informada');
        }
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    public function create($data){
        try{
            $cargoData = ['idcargo' => $data['cargo']['id']];
            unset($data['cargo']);
            $data['password'] = $this->hashPassword($data['password']);
            $create = $this->model->insert($data);
            if($create){
                $cargoData['iduser'] = $create;
                $create = (new UserCargoService)->create($cargoData);
                if($create){
                    setFlash('message', SUCCESS_CREATE_MESSAGE, 'success');
                    back();
                }else{
                    $this->model->delete('id = :id', ['id' => $create]);
                    setFlash('message', FAILED_CREATE_MESSAGE);
                    back();
                }
            }else{
                setFlash('message', FAILED_CREATE_MESSAGE);
                back();
            }
        }catch(\Exception $e){
            setFlash('message', FAILED_CREATE_MESSAGE);
            back();
        }
    }

    public function all($fields = [], $where = '', $data = [], $groupBy = '', $orderBy = '', $limit = '', $join = ''){
        return $this->model->fetchAll($fields, $where, $data, $groupBy, $orderBy, $limit,$join);
    }

    public function one(array $fields = [], $where = '', $data = [], $groupBy = '', $orderBy = '', $limit = '', $join =''){
        return $this->model->fetch($fields, $where, $data, $groupBy, $orderBy, $limit, $join);
    }
}