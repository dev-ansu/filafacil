<?php

namespace app\requests;

use app\interfaces\InterfaceRequest;
use app\requests\Request;

class GuichesUpdateRequest extends Request implements InterfaceRequest{

    public function __construct(){
        parent::__construct($this);
    }

    public function authorize():bool{
        return true;
    }

    public function rules():array{
        return [
            'id' => 'required|existe:guiches',
            'guiche' => 'required|numberInt|unique:guiches',
        ];
    }

    public function messages():array{
        return [
            'guiche.required' => "O campo 'número do guichê' é obrigatório.",
            'guiche.numberInt' => "O campo 'número do guichê' deve ser um número inteiro.",
            'guiche.unique' => "Este guichê já está cadastrado. Tente outro!"
        ];
    }

}