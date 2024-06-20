<?php

namespace app\classes;

/**
 * Tem como objetivo principal validar campos de formulários
 */

class Valida{

    private string|null $field; 
    private array $result = [];
    private $method;
    private $actualMethod;
    private $rgxs;
    /**
     * Método construtor da classe
     * @param string $method - é o método de requisição do formulário, podendo ser POST ou GET
     * @return void
     */

    public function __construct(string $method = "GET"){
        $this->method = $this->whatMethod(strtolower($method));
        $this->rgxs = [
            'pt-br' => '/^(?:\(\d{2}\)\s?|\d{2}\s?)?\d{4,5}-?\d{4}$/',
            'all' => '/^\+(?:\d{1,3})?\s?\d{4,14}$/'
        ];
    }

    
    /**
     * Método impõe o $field (campo requisitado) a ser validado
     * @param string $field - é o campo a ser validado pela classe
     * @return $this
     */

    public function setField($field){
        $this->field = $field;
        return $this;
    }

    /**
     * Método retorna o $field (campo requisitado) a ser validado
     * @return $this->field
     */
    public function getField(){
        return $this->field;
    }

    public function getValue($key){
        if(isList($this->getResult())){
            return $this->result[$key];
        }
    }
    /**
     * Método retorna o valor do campo a ser validado
     * @return mixed
     */
    public function getValueOfField(){
        return isset($this->method[$this->field]) && !empty(trim($this->method[$this->field])) ? strip_tags($this->method[$this->field]):false;
    }

    public function required(){

        $this->setActualMethod(__FUNCTION__);

        if($this->actualMethod != "optional"){
            $value = $this->getValueOfField();
            $this->setResult($value);
            return $this;
        }else{
            throw new \Exception("O método required não pode ser chamado duas vezes ao mesmo tempo e nem após o optional().");
        }

        return false;
    }

    // public function isPhone($region = 'pt-br'){
    //     $regex = '/^[0-9]{1,50}$/i';
    //     if(array_key_exists($region, $this->rgxs)){
    //         $isValid = preg_match($this->rgxs[$region], $this->getValueOfField());
    //         if($isValid){
    //             if($this->actualMethod != "optional"){
    //                 $this->setResult($this->getValueOfField());
    //             }
    //         }
    //         return $this;
    //     }
    //     throw new \Exception('A região não foi encontrada, use: pt-br ou all.');
    // }

    public function isEmail(){  
        $isValid = filter_var($this->getValueOfField(), FILTER_VALIDATE_EMAIL);
        if($this->actualMethod != "optional"){
            $this->setResult($isValid);
        }
        return $this;
    }

    public function custom(callable $callback){
        if(is_callable($callback)){
            $result = call_user_func($callback, $this->getValueOfField());
            if($this->actualMethod != "optional"){
                $this->setResult($result);
            }
            return $this;
        } 
    }

    public function optional(){
        
        if($this->actualMethod == "required"){
            throw new \Exception("O método optional não pode ser chamado após o método required");
            die;
        }
        $value = $this->getValueOfField();
        if($value){
            $this->setResult($value);
        }
        $this->setActualMethod(__FUNCTION__);

        return $this;
    }

    public function isDate($format = 'Y-m-d'){
        $date = $this->getValueOfField();
        if($date){
            $d = \DateTime::createFromFormat($format, $date);     
            if($d && $d->format($format) == $date){
                $this->setResult($date);
                return $this;
            }   
        }
        if($this->actualMethod != "optional"){
            $this->setResult(false);
        }
        return $this;
    }

    public function getResult(){
        if(in_array(false, array_values($this->result))){
            return false;
        }
        return $this->result;        
    }

    
    public function setMessage($message){
        if($this->actualMethod != "optional" && !is_array($this->getResult())){
            setFlash($this->field, $message);
            return $this;
        }
        return $this;
    }
    

    private function whatMethod($method){
        switch ($method){
            case "get":
                return $_GET;
                break;
            case "post":
                return $_POST;
                break;
            default:
                return $_GET;
                break;
        }
    }

    private function setResult($value){
        $this->result[$this->field] = $value;
    }

    private function setActualMethod($actualMethod){
        $this->actualMethod = $actualMethod;
    }
    
}