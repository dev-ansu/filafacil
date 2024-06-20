<?php
namespace app\core\Components;

use app\core\Components\Component;

class LinkNavigation extends Component{

    public function __construct(string $href = '', $options = [], $parent = null){
        parent::__construct('a', $options, $parent);
        $this->element->setAttribute('href', $href);
    }

}