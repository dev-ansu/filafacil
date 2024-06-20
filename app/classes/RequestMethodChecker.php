<?php
namespace app\classes;


class RequestMethodChecker{
    public static function check(string $method = "GET", string $redirectTo = ''){
        if(strtoupper(trim($method)) != trim($_SERVER['REQUEST_METHOD'])){
            setFlash("message", "Não foi possível validar as informações. Tente novamente!");
            header("location:" . URL_BASE . $redirectTo, true, 302);
            die;
        }
    }
}