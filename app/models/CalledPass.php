<?php 

namespace app\models;
use app\core\Model2;

class CalledPass extends Model2{

    protected $table = 'called_pass';
    protected $fillable = ['idpass','iduser'];
    
    public function __construct($alias = ''){
        if(trim($alias)){
            $this->table.=" $alias";
        }
        
        $this->db();
    }
    
}