<?php

namespace app\classes;
use app\classes\SessionManager;
use Exception;

class SessionLogin extends SessionManager{
    
    public static function setLoginSession($value = []){
        if(!is_array($value) && !is_object($value)){
            throw new Exception("O valor passado não é um array");
            die;
        }
        session_regenerate_id();
        self::setKey(SESSION_OWNER_LOGIN)::setValue(self::getAndCryptAgentUserAndAddr())::setSession();
        self::setKey(SESSION_LOGIN)::setValue($value)::setSession();                
    }

    public static function removeLoginSession(){
        if(self::has(SESSION_LOGIN)){
            return self::remove(SESSION_LOGIN);
        }
        return true;
    }

}