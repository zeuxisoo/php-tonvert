<?php
namespace Tonvert\Model\TransformedNode;

use Tonvert\Model\TransformedNode\Type as TransformedNodeType;

class Identifier extends TransformedNodeType {

    private $name = '';

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

}
