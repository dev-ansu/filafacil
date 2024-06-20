<?php

namespace app\requests;
use app\requests\Request;
use app\interfaces\InterfaceRequest;

class UsersRequest extends Request implements InterfaceRequest{

    public function __construct(){
        parent::__construct($this);
    }

    public function authorize():bool{
        return true;
    }

    public function rules():array{
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'user' => 'required|unique:users|minlen:3|maxlen:50',
            'password' => 'required|minlen:6',
            'cargo' => "required|existe:cargos-id",
        ];
    }

    public function messages():array{
        return [
            'firstname.required' => "O campo nome é obrigatório.",
            'lastname.required' => "O campo sobrenome é obrigatório.",
            "user.minlen" =>"O campo usuário deve ter no mínimo 3 caracteres.",
            "user.maxlen" =>"O campo usuário deve ter no máximo 50 caracteres.",
            'user.required' => "O campo usuário é obrigatório.",
            'user.unique' => "Este usuário já existe. Escolha outro!",
            'password.required' => "O campo de senha é obrigatório",
            'password.minlen' => "O campo de senha deve ter no mínimo 6 caracteres.",
            'cargo.required' => "O campo cargo é obrigatório",
            'cargo.existe' => "Este cargo não está cadastrado.",
        ];
    }

}