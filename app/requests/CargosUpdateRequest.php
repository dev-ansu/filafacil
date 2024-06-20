<?php

namespace app\requests;

use app\interfaces\InterfaceRequest;
use app\requests\Request;

class CargosUpdateRequest extends Request implements InterfaceRequest{

    public function __construct(){
        parent::__construct($this);
    }

    public function authorize():bool{
        return true;
    }

    public function rules():array{
        return [
            'id' => 'required|existe:cargos',
            'cargo' => 'required',
            'salario' => 'required|numeric',
        ];
    }

    public function messages():array{
        return [
            'cargo.required' => "O campo 'nome do cargo' é obrigatório.",
            'salario.required' => "O campo 'salário' é obrigatório.",
            'salario.numeric' => "O campo salário deve ser numérico",
        ];
    }

}