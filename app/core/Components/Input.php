<?php
namespace app\core\Components;

use app\core\Components\Component;

class Input extends Component{
    
    public function __construct(string $type = 'text', string $name, $options = [], $parent = null){
        if(in_array('class', array_keys($options))){
            if(!str_contains($options['class'], 'form-control')){
                $options['class'] = $options['class'] . " form-control";                
            }
        }
        parent::__construct('input', $options, $parent);
        $this->element->setAttribute('type', $type);
        $this->element->setAttribute('name', $name);
    }

}