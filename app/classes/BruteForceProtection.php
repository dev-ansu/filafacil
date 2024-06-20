<?php

namespace app\classes;

class BruteForceProtection{
    protected static $tentativas;
    protected static $action;
    public static function set($tentativas = 3, $time = 3){
        self::$tentativas = $tentativas;
        if(!isset($_SESSION['_brute'][self::$action])){
            $_SESSION['_brute'][self::$action] = [
                'tentativas' => 0,
                'time' => today('H:i:s'),
                'ip' => $_SERVER['REMOTE_ADDR'],
            ];
        }else{
            $_SESSION['_brute'][self::$action]['tentativas'] = $_SESSION['_brute'][self::$action]['tentativas'] + 1;
            $_SESSION['_brute'][self::$action]['time'] = date("H:i:s", strtotime($_SESSION['_brute'][self::$action]['time'] . "+$time minutes"));
        }        
        return $_SESSION['_brute'][self::$action];
    }

    public static function get(){
        $_BRUTE = isset($_SESSION['_brute'][self::$action]) ? $_SESSION['_brute'][self::$action]:false;
        return $_BRUTE;
    }

    public static function delete(){
        unset($_SESSION['_brute'][self::$action]);
    }

    private static function deleteExpired(){
        if(isset($_SESSION['_brute'][self::$action]) && $_SESSION['_brute'][self::$action]['time'] < today("H:i:s")) unset($_SESSION['_brute'][self::$action]);
    }
    public static function check($message = "Muitas tentativas.", $tentativas = 3, $minutes = 3, $action){
        self::deleteExpired();
        self::$action = $action;
        $_BRUTE = isset($_SESSION['_brute'][self::$action]) ? $_SESSION['_brute'][self::$action]:false;
        if($_BRUTE){
            $message = $message . " Espere até: " . $_BRUTE['time'];
        }
        if(!$_BRUTE) return self::set($tentativas, $minutes);
        if($_BRUTE['tentativas'] >= self::$tentativas && $_BRUTE['time'] > today("H:i:s")){
            setFlash('message', $message);
            back();
        }else{
            return self::set($tentativas, $minutes);
        }
    }

}