<?php

namespace app\classes;
use Exception;

abstract class SessionManager{

    protected static $key = null;
    protected static $sessionsKeys = [];
    protected static $value = null;

    /**
     * Valida se a chave para a sessão é uma string
     * @param string $key
     * @throws Exception
     */
    
    private static function validateKey(string $key){
        if(!is_string($key)){
            throw new Exception('A chave deve ser uma string.');
            die;
        }
        return true;
    }

    public static function setValue($value){
        self::$value = $value;
        return self::class;
    }

    public static function getValue(){
        return self::$value;
    }

    public static function setKey(string $key = SESSION_LOGIN){
        self::validateKey($key);
        if(in_array($key, self::$sessionsKeys)){
            throw new Exception('Esta chave já existe na lista de sessões.');
        }
        self::$key = $key;
        self::$sessionsKeys[] = $key;
        return self::class;
    }

    private static function set(){
        $_SESSION[self::$key] = self::$value;
    }

    public static function setSession(){
        if(!empty(self::$value)){
            self::set();
        }
        return self::class;
    }

    public static function getSession(string $key = SESSION_LOGIN){
        self::validateKey($key);
        if(!self::has($key)){
            throw new Exception("Não há sessão ativa com esta chave.");
            die;
        }
        return $_SESSION[$key];
    }

    public static function getSessionsKeys(){
        return self::$sessionsKeys;
    }

    public static function has(string $key = SESSION_LOGIN){
        self::validateKey($key);
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key = SESSION_LOGIN){
        self::validateKey($key);
        unset($_SESSION[$key]);
        if(!self::has()){
            return true;
        }
        return false;
    }

    public static function getAndCryptAgentUserAndAddr(){
        return md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
    }

}