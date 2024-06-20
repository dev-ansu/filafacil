<?php
namespace app\core\Components;

use app\core\Components\LinkNavigation;

class EditLink extends LinkNavigation{

    public function __construct(string $href = '', $options = [], $parent = null){
        parent::__construct($href, $options, $parent);
        $attrClassExist = $this->verifyAttributes('class', $options);
        if(!$attrClassExist){
            $options['class'] = 'btn btn-primary '; 
        }else{
            if(preg_match('/^btn(\sbtn)/', $options['class']) <= 0){
                $options['class'] = 'btn btn-primary '.$options['class'];
            }
        }
        $this->element->setAttribute('class', 'btn btn-primary');
        $this->element->setAttribute('title', 'Editar registro');
        $this->bsIconPlusText('Editar', 'bi bi-pencil');
    }

}