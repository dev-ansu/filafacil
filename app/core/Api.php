<?php

namespace app\core;

abstract class Api{

    protected $success;
    protected $message;
    protected $data;

    final protected function load(){
        echo json_encode($this->getResponse());
        return;
    } 
    
    final public function __set($key, $value){
        $this->$key = $value;
    }

    final public function __get($key){
        return $this->$key;
    }

    private function getResponse(){
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
        ];
    }
}