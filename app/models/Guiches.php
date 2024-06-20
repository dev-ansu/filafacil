<?php 

namespace app\models;
use app\core\Model2;

class Guiches extends Model2{

    protected $table = 'guiches';
    protected $fillable = ['guiche'];
    
    public function __construct(){
        $this->db();
    }
    
}