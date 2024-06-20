<?php
namespace app\core\Components;

use app\core\Components\Component;

class Label extends Component{

    public function __construct(string $for = '', $options = [], $parent = null){
        parent::__construct('label', $options, $parent);
        $this->element->setAttribute('for', $for);
    }

}