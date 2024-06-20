<?php 

namespace app\models;
use app\core\Model2;

class Permissions extends Model2{

    protected $table = 'permissions';
    protected $fillable = ['permission_name', 'description'];
    
    public function __construct(){
        $this->db();
    }
    
}