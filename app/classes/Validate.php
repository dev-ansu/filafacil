<?php
namespace app\classes;

use app\models\DAO;
use app\requests\Request;
use DateTime;

class Validate{
    
    protected static array $errors = [];
    protected static $method;
    protected static $request;

    protected static $messages;

    public static function validate(array|Request $validacoes){
        
        if(!self::$method){
            $method = $_SERVER['REQUEST_METHOD'];
            if(strtolower($method) == 'get'){
                self::$method = $_GET;
            }else{
                self::$method = $_POST;
            }
        }

        $result = [];
        $param = '';
        if($validacoes instanceof Request){
            $rules = $validacoes->rules(); 
            if(method_exists($validacoes, 'messages')){
                self::$messages = $validacoes->messages();
            }            
        }else{
            $rules = $validacoes;
        }

        foreach($rules as $field => $validate){
 
            $result[$field] = (!str_contains($validate, "|")) ?
            [$validate, $param] = self::validacaoUnica($validate, $field, $param):
            $result[$field] = self::validacaoMultipla($validate, $field, $param);
            
           
        }
        if(in_array(false, $result, true)){
            return false;
        }
        return $result;
    }

    private static function validacaoUnica($validate, $field, $param){
        if(str_contains($validate, ":")){
            [$validate, $param] = explode(":", $validate);
        }
        return self::$validate($field, $param);
    }
    
    private static function validacaoMultipla($validate, $field, $param){
        $result = [];
        $explodeValidatePipe = explode("|", $validate);
        foreach($explodeValidatePipe as $validate){
   
            if(str_contains($validate, ":")){
                [$validate, $param] = explode(":", $validate);
            }
               
                $result[$field] = self::$validate($field, $param);

                if($result[$field] === false || $result[$field] === null){
                    break;
                }
            }
            return $result[$field];
    }
    

    private static function valideISODate($field){
        $accepted = ['Y-m-d', 'Y-m-d H:i:s'];
        $date = isset($_REQUEST[$field]) ? strip_tags($_REQUEST[$field]):'';

        if($date){
            foreach($accepted as $formato){
                $dateTimeObj = DateTime::createFromFormat($formato, $date);
                if($dateTimeObj !== false && $dateTimeObj->format($formato) === $date){
                    return strip_tags($date);
                }
            }
        }

        return false;
    }

    private static function valideTime($field, $param){
        $valor = isset($_REQUEST[$field]) ? $_REQUEST[$field]:'';
        if($valor){
            $param = str_replace("-", ":", $param);
            if(is_array($valor)){
                $res = array_map(function($v) use($param){
                    $time = date($param, strtotime($v));
                    if($time == $v){
                        return strip_tags($v);
                    }
                }, $valor);
                return $res;
            }
            $time = date($param, strtotime($valor));
            if($time == $valor){
                return strip_tags($valor);
            }
        }
        return false;
    }

    private static function valideNumber($field){
        $valor = isset($_REQUEST[$field]) ? $_REQUEST[$field]:'';

        if($valor){
           
            $float = floatval($valor);
            if($float == $valor || is_int($valor)){
                return strip_tags($valor);
            }
        }
        return false;
    }

    public static function setMessages(){
        $object = self::$request;
        if(method_exists($object, 'messages')){
            if($object->messages()){
                foreach($object->messages() as $key => $value){
                    if(str_contains($key,".")){
                        [$field, $method] = explode(".",$key);
                        if(isset(self::$errors[$field][$method])){
                            self::$errors[$field][$method] = $value;
                        }
                    }
                }
            }
        }
    }
    
    public static function setFlashMessages(){
        self::setMessages();
        foreach(self::$errors as $field => $methods){
            foreach($methods as $method => $message){
                setFlash($field.".".$method, $message);
            }
        }
    }

    private static function setError($field, $method, $value){
        if(!isset(self::$errors[$field])){
            self::$errors[$field] = [$method => $value];
        }else{
            self::$errors[$field][$method] = $value;
        }
        return self::class;
    }

    protected static function getErrors(){
        self::setMessages();
        return self::$errors;
    }

    private static function required($field){
        $value = isset(self::$method[$field]) ? self::$method[$field]:false;

        if(!$value){
            self::setError($field, 'required','O campo é obrigatório'); 
            return false;
        };

        if(!is_array($value)){
            if((empty(trim($value)) || trim($value) == '')){
                self::setError($field, 'required','O campo é obrigatório'); 
                return false;
            }else{
                return strip_tags($value);
            }
        }elseif(is_array($value)){
            if(count(array_values($value)) <= 0){
                self::setError($field, 'required', 'O campo é obrigatório'); 
                return false;
            }else{
                return array_map(fn($v)=> strip_tags($v), $value);
            }
        }      
          
    }
    private static function numberInt($field){
        $number = isset($_REQUEST[$field]) ? intval($_REQUEST[$field]):"";
        if(is_int($number)){
            return $number;
        }        
        return null;
    }

    private static function notNull($field){
        $value = isset(self::$method[$field]) ? self::$method[$field]:false;
        
        if(empty(trim($value)) || trim($value) == ''){
            self::setError($field, 'notNull', 'O campo não pode ser vazio.'); 
            return false;
        }
        return strip_tags($_REQUEST[$field]);
    }
    private static function email($field){
        $emailIsValid = filter_input(INPUT_POST, $field, FILTER_VALIDATE_EMAIL);
        if(!$emailIsValid){
            setFlash($field, "O campo precisa ter um {$field} válido.");
            return false;
        }
        
        return filter_input(INPUT_POST, $field, FILTER_SANITIZE_EMAIL);
    }

    private static function maxlen($field, $param){
        $data = strip_tags(self::$method[$field]);
        if(strlen($data) > $param){
            setFlash($field, "O campo {$field} tem um limite de {$param} caracteres.");
            return false;
        }
        return $data;
    }

    private static function minlen($field, $param){
        $data = strip_tags(self::$method[$field]);
        if(strlen($data) < $param){
            setFlash($field, "O campo {$field} tem um limite de {$param} caracteres.");
            return false;
        }
        return $data;
    }

    private static function verifyUnique($model, $field, $value){
        
        if(class_exists($model)){
            $usuario = new $model();
            $existe = $usuario->fetch(where:"$field = :$field", data:[$field => $value]);
            
            if($existe){
                self::setError($field, 'unique', 'Este registro já existe'); 
                return false;
            }

            return $value;
        }else{
            throw new \Exception("Esta model não existe");
        }
    }

 

    private static function verifyExist($model, $field, $value){
        
        if(class_exists($model)){

            $usuario = new $model();
            $existe = $usuario->fetch(where:"$field = :$field", data:[$field => $value]);
            
            if($existe){
                return [$field => $value, 'data' => $existe];
            }

            self::setError($field, 'existe', 'Este registro já existe'); 
            return false;
        }else{
            throw new \Exception("Esta model não existe");
        }
    }

    private static function numeric($field){
        $value = isset(self::$method[$field]) ? strip_tags(self::$method[$field]):false;

        if($value && is_numeric($value)){
            return $value;
        }
        self::setError($field, 'numeric','O campo deve ser numérico.'); 

        return false;
    }

    private static function unique($field, $param){
        $value = isset(self::$method[$field]) ? self::$method[$field]:false;

        if(!$value){
            self::setError($field, 'unique','O campo é obrigatório'); 
            return false;
        };

        if($value){
            $value = strip_tags($value);
            if(str_contains($param, "-")){
                $params = explode("-", $param);
                $model = "app\\models\\" . ucfirst($params[0]);
                return self::verifyUnique($model, $params[1], $value);
            }else{
                $model = "app\\models\\" . ucfirst($param);
                return self::verifyUnique($model, $field, $value);
            }         
              
        }
        return $value;
    }

    private static function image($field, $param){
        $filename = $_FILES[$field];
    }

    private static function existe($field, $param){
     
        $value = isset(self::$method[$field]) ? self::$method[$field]:false;
        if(!$value){
            self::setError($field, 'unique','O campo é obrigatório'); 
            return false;
        };  
        
        if($value){
            if(is_array($value)){
                foreach($value as $v){
                    if(str_contains($param, "-")){
                        $params = explode("-", $param);
                        $model = "app\\models\\" . ucfirst($params[0]);
                        return self::verifyExist($model, $params[1], $v);
                    }else{
                        $model = "app\\models\\" . ucfirst($param);
                        return self::verifyExist($model, $field, $v);
                    }   
                }
            }
            $value = strip_tags($value);
            if(str_contains($param, "-")){
                $params = explode("-", $param);
                $model = "app\\models\\" . ucfirst($params[0]);
                return self::verifyExist($model, $params[1], $value);
            }else{
                $model = "app\\models\\" . ucfirst($param);
                return self::verifyExist($model, $field, $value);
            }         
              
        }

        return $value;
    }


    private static function data($field){
        $data = isset($_REQUEST[$field]) ? $_REQUEST[$field]:'';
        $date = '';
        if(str_contains($data, "-")){
            $newDataArray = explode("-", $data);
            $dateArray = [
                "dia" => $newDataArray[2],
                "mes" => $newDataArray[1],
                "ano" => $newDataArray[0]
            ];
            $date = checkdate($dateArray["mes"], $dateArray["dia"], $dateArray["ano"]);
            if($date){   
                // $data = $dateArray["dia"]."/".$dateArray["mes"]."/".$dateArray["ano"];     
                return $data;
            }
        }

        if(str_contains($data, "/")){
            $newDataArray = explode("/", $data);
            $dateArray = [
                "dia" => $newDataArray[0],
                "mes" => $newDataArray[1],
                "ano" => $newDataArray[2]
            ];
            $date = checkdate($dateArray["mes"], $dateArray["dia"], $dateArray["ano"]);
            if($date){   
                return $data;
            }
        }
        setFlash("message", "Defina uma data válida.");
        return false;
    }

    private static function color($field){
        $cor_validate = strip_tags($_REQUEST[$field]);
        $pattern = '/[0-9a-fA-F]{6}$/';
        if(preg_match($pattern, $cor_validate) > 0){
            return $cor_validate;
        }
        return false;
    }

    private static function senha($field){
        $senha = strip_tags(self::$method[$field]);
        $newSenha = password_hash($senha, PASSWORD_DEFAULT);
        return $newSenha;
    }
    private static function optional($field){
        $value = isset(self::$method[$field]) ? self::$method[$field]:null;

        if(!is_array($value)){
            if((empty(trim($value)) || trim($value) == '')){
                return null;
            }else{
                return strip_tags($value);
            }
        }elseif(is_array($value)){
            if(count(array_values($value)) <= 0){
                return null;
            }else{
                return array_map(fn($v)=> strip_tags($v), $value);
            }
        }  
        return null;
    }
    private static function telefone($field){

        $data = '';

        if(isset(self::$method[$field])){
            $data = strip_tags(self::$method[$field]);
        }

        if(isset(self::$method[$field])){
            $data = strip_tags(self::$method[$field]);
        }

        if($data){
            $regex = '/^[0-9]{1,50}$/i';
            $teste = preg_match($regex, $data);
            
            if($teste == 1){
                return $data;
            }else{
                setFlash($field, "Digite um telefone válido. Sem espaços, parênteses e hifen.");
                return null;
            }
        }
        
        return null;
        
    }
    
}