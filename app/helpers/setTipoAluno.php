<?php

function is_list(array $data){
    return strpos(json_encode($data), "[") === 0;
}

function setTipo(array $alunos, string $tipo){
    $alunos = is_list($alunos) ? json_decode(json_encode($alunos), true):$alunos;

    foreach($alunos as $key => $aluno){
        if(!isset($alunos[$key]['tipoAluno'])){
            $alunos[$key]['tipoAluno'] = $tipo;
        }
    }
    return json_decode(json_encode($alunos));
}

