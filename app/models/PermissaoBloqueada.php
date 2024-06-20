<?php 

namespace app\models;
use app\core\Model2;

class PermissaoBloqueada extends Model2{

    protected $table = 'permissao_bloqueada';
    protected $fillable = ['idcargo', 'idpermission'];
    
    public function __construct(){
        $this->db();
    }
    
}