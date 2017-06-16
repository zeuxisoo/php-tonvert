<?php
namespace Tonvert\Model\TransformedNode;

use Tonvert\Model\TransformedNode\Type as TransformedNodeType;

class StringLiteral extends TransformedNodeType {

    private $value = '';

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

}
