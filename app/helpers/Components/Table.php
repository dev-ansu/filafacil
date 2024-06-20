<?php

function UnorderedList(array $props, array $children){
    $html = "<ul ";
    foreach($props as $key => $prop){
        $html.="{$key}='{$prop}'";
    }
    $html.=">";
    foreach($children as $child){
        $html.= $child;
    }
    $html.="</ul>";
    return $html;
}

function Container(array $props, array $children){
    $html = "<div ";
    foreach($props as $key => $prop){
        $html.="{$key}='{$prop}'";
    }
    $html.=">";
    foreach($children as $child){
        $html.= $child;
    }
    $html.="</div>";
    return $html;
}

function TRow($record){
    $toCenter = ['codigocontrato', 'computador','ipcomputador'];
    $keys = array_keys(get_object_vars($record));

    $status = ['1' => "<i title='Aluno cursando' class='bi fs-4 text-primary bi-pc-display'></i>", '2' => "<i title='Aluno concluído' class='bi fs-4 text-success bi-check2-all'></i>", "3" => "Cancelado", "<i class='bi fs-4 text-danger bi-x-lg'></i>4" => "<i class='bi fs-4 text-warning bi-cash-coin'></i>", "5" => "<i class='bi fs-4 text-white bi-slash-circle'></i>"];
    $html = "<tr class='searching' id='n{$record->CodigoContrato}'>";
    $class = "class='text-center'";

    foreach($keys as $key){
        if(strtolower($key) == "status"){
            $html.="<td>".$status[$record->STATUS]."</td>";
            continue;
        }
        if(isset(HEAD[$key])){
            if(in_array(strtolower($key), $toCenter)){
                $html.= "<td {$class}>{$record->$key}";
            }else{
                $html.= "<td>{$record->$key}";
            }
            $html.= "</td>";
        }
        
    }
        $html.="<td>";
            $html.="<div class='btn-group dropup'>";
                $html.="<button type='button' class='btn btn-secondary dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>Ações";
                $html.="</button>";
                $html.='<ul class="dropdown-menu bg-dark">';
                $html.='<div class="d-flex justify-content-start">';
                $html.=Button(['class'=> "btn dropdown-item mx-1 btn-warning", 'type' => "button", 'value' => $record->CodigoContrato, 'title' => 'Ver históricos do aluno', 'data-bs-toggle' => 'modal', 'data-bs-target' => "#historicos"], ["<i class='bi bi-file-earmark-medical'></i>"]);
                $html.=Button(['class' => 'btn dropdown-item mx-1 btn-primary btnContatos','type' => "button", 'value' => $record->CodigoContrato, 'title' => 'Cadastrar histórico e ver contatos do aluno', 'data-bs-toggle' => 'modal', 'data-bs-target' => "#contatos"], ["<i class='bi bi-telephone-outbound'></i>"]);
                $html.=Button(['class'=>'btn dropdown-item buttonPausarMensagens btn-primary','type' => "button", 'value' => $record->CodigoContrato, 'title' => 'Pausar mensagens automáticas paro aluno(a)', 'data-bs-toggle' => 'modal', 'data-bs-target' => "#pausarMensagens"], ["<i class='bi bi-stop-circle'></i>"]);
                    if(isset($record->tipoAluno) && $record->tipoAluno == 'prepara'):
                        $CodigoContrato = base64_encode($record->CodigoContrato);
                        $SenhaAluno = isset($record->SenhaAluno) ? base64_encode($record->SenhaAluno):"Prep-123";
                        $html.=Button(['class'=>"btn dropdown-item mx-1 btn-primary",'onclick'=>"copyLink(`$CodigoContrato`, `$SenhaAluno)`)", 'type' => "button", 'value' => $record->CodigoContrato, 'title' => 'Copiar link de acesso do aluno'],['<i class="bi bi-link-45deg"></i>']);
                    endif;
                    if(isset($record->Codigo)){
                        $html.=LinkButton(
                            [
                                'class' => 'btn excluirPresenca mx-1 btn-danger',
                                'title'=>'Excluir presença do aluno',
                                'href'=> URL_BASE . "admin/presencas/excluirPresenca?Codigo=$record->Codigo",
                            ],
                            ['<i class="bi bi-x-lg"></i>']
                        );
                    } 
                    if(isset($record->tipoAluno) && $record->tipoAluno == 'ouro'){
                        
                        if(isset($record->CodigoAgendamento)){

                            $html.=LinkButton(
                                [
                                    'class' => 'btn btn-primary mx-1',
                                    'title'=>'Excluir horário do aluno',
                                    'data-aya-target'=> "n{$record->CodigoAgendamento}",
                                    'href'=> URL_BASE . "admin/agenda/excluirHorario".isset($record->CodigoAgendamento) ? "&ID={$record->CodigoAgendamento}":"" ,
                                ],
                                ['<i class="bi bi-x-lg"></i>']
                            );

                        }
                        $html.=LinkButton(
                            [
                                'class' => 'btn btn-primary mx-1',
                                'title'=>'Editar aluno',
                                'href'=> URL_BASE . "admin/listar/editar?ID={$record->ID}&origem=" . $_SERVER['PHP_SELF'],
                            ],
                            ['<i class="bi bi-pencil"></i>']
                        );
                        if(isset($aluno->BLOQUEADO)  && $aluno->BLOQUEADO == 0){
                            $html.=LinkButton(
                                [
                                    'class' => 'btn mx-1 btn-danger',
                                    'title'=>'Bloquear acesso do aluno',
                                    'href'=> URL_BASE . "admin/listar/bloquearAcesso?ID=".$record->ID,
                                ],
                                ["<i class='bi mx-1 text-danger bi-slash-circle'></i>"]
                            );
                        }else{
                            $html.=LinkButton(
                                [
                                    'class' => 'btn mx-1 btn-danger',
                                    'title'=>'Desbloquear acesso do aluno',
                                    'href'=> URL_BASE . "admin/listar/bloquearAcesso?ID=". $record->ID ,
                                ],
                                ['<i class="bi text-success bi-check-circle">']
                            );
                        }
                        
                    }
                    
                $html.="</div>";
            $html.="</ul>";
            $html.="</div>";
        $html.="</td>";
    $html.= "<tr>";
    return $html;
}


function THead($keys){
  
    $html = "<thead>";
    $html.= "<tr class='text-center'>";
    foreach($keys as $key){
        if(isset(HEAD[$key])){
            $html.= "<th>";
            $html.= HEAD[$key];
            $html.="</th>";
        }
    }
    $html.="<th>Ações</th>";
    $html.="</tr>";
    $html.= "</thead>";
    return $html;
}

function Table(array $data, array $props = []){
    $keys = array_keys(get_object_vars($data[0]));

    $html = "<table ";
    foreach($props as $key => $value){
        $html.= "{$key}='{$value}' ";
    }
    $html.= ">";
    if($data && is_array($data)){
      $html.= THead($keys);
      foreach($data as $record){
        $html.= TRow($record);
      }
      $html.= "</table>";
      return $html;
    }

    return false;
}
