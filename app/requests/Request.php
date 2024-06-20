<?php

namespace app\requests;

use app\classes\Validate;

class Request extends Validate{

    private $data;

    public function __construct(Request $req){
        if($req instanceof Request){
            if(strtolower($_SERVER['REQUEST_METHOD']) == 'get'){
                self::$method = $_GET;
            }elseif(strtolower($_SERVER['REQUEST_METHOD']) == 'post'){
                self::$method= $_POST;
            }
            self::$request = $req;
        }
    }

    public function data(){
        return $this->data;
    }

    public static function setOld(){
        foreach(self::$method as $key => $old){
            if($key !== '_csrf'){
                setOld($key, $old);
            }
        }
    }
    
    public function validated(){
        if(Validate::$request->authorize()){
            $validate = $this->validate(Validate::$request);
            $this->data = $validate;
            return $this;
        }else{
            setFlash('message', 'Você não tem autorização para esta ação.');
            historyBack();
        }
    }

    public function errors(){
        return Validate::getErrors();
    }

}