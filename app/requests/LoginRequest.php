<?php

namespace app\requests;

use app\interfaces\InterfaceRequest;
use app\requests\Request;

class LoginRequest extends Request implements InterfaceRequest{

    public function __construct(){
        parent::__construct($this);
    }

    public function authorize():bool{
        return true;
    }

    public function rules():array{
        return [
            'user' => 'required|existe:users',
            'password' => 'required',
        ];
    }

    public function messages():array{
        return [
            'user.required' => "O campo usuário é obrigatório.",
            'password.required' => "O campo senha é obrigatório.",
            'user.existe' => 'Nenhum usuário encontrado com estas informações.',
        ];
    }

}