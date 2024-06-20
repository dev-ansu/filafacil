<?php
namespace app\classes;


class SessionKeyGenerator{

    public static function generate(int $length = 32){
        $chars = self::getSessionChars();
        $charsLength = strlen($chars);
        $key = '';
        for($i = 0; $i < $length; $i++){
            $key .= $chars[self::getRandomIndex($charsLength)];
        }
        return $key;
    }

    private static function getSessionChars(){
        return $_ENV['SESSION_CHARS'];
    }

    private static function getRandomIndex(int $length){
        if(function_exists('random_int')){
            return random_int(0, $length - 1);
        }else{
            return mt_rand(0, $length - 1);
        }
    }

}