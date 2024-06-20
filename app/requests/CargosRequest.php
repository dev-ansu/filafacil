<?php

namespace app\requests;

use app\interfaces\InterfaceRequest;
use app\requests\Request;

class CargosRequest extends Request implements InterfaceRequest{

    public function __construct(){
        parent::__construct($this);
    }

    public function authorize():bool{
        return true;
    }

    public function rules():array{
        return [
            'cargo' => 'required|unique:cargos',
            'salario' => 'required|numeric',
        ];
    }

    public function messages():array{
        return [
            'cargo.required' => "O campo 'nome do cargo' é obrigatório.",
            'cargo.unique' => "Este cargo já está cadastrado. Tente outro!",
            'salario.required' => "O campo 'salário' é obrigatório.",
            'salario.numeric' => "O campo salário deve ser numérico",
        ];
    }

}