<?php

namespace app\controllers\admin;

use app\classes\Validate;
use app\core\Controller;
use app\middlewares\SessionMiddleware;
use app\models\PermissaoBloqueada;
use app\models\Permissions;
use app\services\CargosService;
use app\services\PermissaoBloqueadaService;
use app\services\PermissoesService;

class ConfiguracoesController extends Controller{

    function __construct(){
        SessionMiddleware::handleRequest("/login");
    }


    public function index(){
        $cargos = (new CargosService())->all(['id', 'cargo', 'salario']);
        $data = [
            "pageTitle" => "Página inicial - EasyQueue", 
            'title' => "Configurações",
            "view" => "admin/pages/configuracoes/Index",
            'cargos' => $cargos['data'],
        ];

        $this->load("template", $data);
    }

    public function getPermissionsBlocked(){

        $validate = (new Validate)->validate([
            'id' => 'required',
        ]);

        if($validate){
            $permissions = (new PermissoesService())->all(['permissions.id','permission_name','surname','description','idcargo','idpermission'], data:['idcargo' => $validate['id']],join:"
                LEFT JOIN permissao_bloqueada pb ON pb.idpermission = permissions.id AND pb.idcargo = :idcargo
            ");

            if($permissions){
                echo json_encode([
                    'success' => true,
                    'data' => $permissions['data'],
                ]);
                return;
            }else{
                echo json_encode([
                    'success' => false,
                    'message' => 'Nada encontrado',
                ]);
                return;
            }
        }else{   
            echo json_encode([
                'success' => false,
                'validate' => $validate,
                'message' => 'Não foi possível validar os dados.',
            ]);
            return;
        }

    }

    public function blockPermission(){
        $validate = (new Validate)->validate([
            'idcargo' => "required|existe:cargos-id",
            "idpermission" => "optional",
        ]);

        if($validate){
            $has = (new PermissaoBloqueada())->fetchAll(where:'idcargo = :idcargo', data:['idcargo' => $validate['idcargo']['id']]);
            if(!$validate['idpermission']){
                $deleted = (new PermissaoBloqueada())->delete('idcargo = :idcargo', ['idcargo' => $validate['idcargo']['id']]);
                setFlash("message",'Funções desbloqueadas com sucesso!','success');
                back();
            }
            if($has['count'] > 0){
                $deleted = (new PermissaoBloqueada())->delete('idcargo = :idcargo', ['idcargo' => $validate['idcargo']['id']]);
                if($deleted){
                    $total = count($validate['idpermission']);
                    $i = 0;
                    foreach($validate['idpermission'] as $permission){
                        try{
                            $inserted = (new PermissaoBloqueada())->insert(['idcargo' => $validate['idcargo']['id'], 'idpermission' => $permission]);
                            if($inserted){
                                $i += 1;
                            }else{
                                throw new \Exception("Ocorreu um erro ao tentar inserir a permissão.");
                            }
                        }catch(\Exception $e){
                            setFlash("message", 'Ocorreu um erro ao tentar inserir a permissão.');
                            back();
                        }
                    }

                    if($i >= $total){
                        setFlash("message",'Funções bloqueadas com sucesso!','success');
                        back();
                    }
                }else{
                    setFlash("message",'Não foi possível bloquear as funções. Tente novamente!');
                    back();
                }
            }else{
                $total = count($validate['idpermission']);
                    $i = 0;
                    foreach($validate['idpermission'] as $permission){
                        try{
                            $inserted = (new PermissaoBloqueada())->insert(['idcargo' => $validate['idcargo']['id'], 'idpermission' => $permission]);
                            if($inserted){
                                $i += 1;
                            }else{
                                throw new \Exception("Ocorreu um erro ao tentar inserir a permissão.");
                            }
                        }catch(\Exception $e){
                            setFlash("message", 'Ocorreu um erro ao tentar inserir a permissão.');
                            back();
                        }
                    }

                    if($i >= $total){
                        setFlash("message",'Funções bloqueadas com sucesso!','success');
                        back();
                    }
            }
            
        }else{
            setFlash("message",'Não foi possível validar os dados. Tente novamente!');
            back();
        }
    }

}