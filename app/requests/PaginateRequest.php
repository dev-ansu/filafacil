<?php

namespace app\requests;
use app\requests\Request;

class PaginateRequest extends Request{

    public function __construct(){
        parent::__construct($this);
    }

    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'page' => 'optional',
            'search' => 'optional',
        ];
    }

    // public function messages(){
    //     return [
    //         'Usuario.notNull' => "O campo usuário não pode ser vazio.",
    //         'Usuario.required' => "O campo de usuário é obrigatório.",
    //         'Senha.required' => "O campo de senha é obrigatório.",
    //         'Senha.notNull' => "O campo de senha não pode ser vazio.",
    //     ];
    // }

}