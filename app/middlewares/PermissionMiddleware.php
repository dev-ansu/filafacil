<?php 

namespace app\middlewares;

use app\models\Permissions;

class PermissionMiddleware{

    public static function check($url, $idcargo){
        $permissions = (new Permissions)->fetch(
        ['permissions.id', 'permissions.permission_name'], where:'
            permissions.permission_name = :url 
            AND
            pb.idcargo = :idcargo
            AND
            permissions.type = "route"
        ',data:['url' => $url, 'idcargo' => $idcargo], join:'
            LEFT JOIN permissao_bloqueada pb ON pb.idpermission = permissions.id
        ');
        
        if($permissions){
            return true;
        }
        return false;
    }
}