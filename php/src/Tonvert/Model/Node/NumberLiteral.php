<?php
namespace Tonvert\Model\Node;

use Tonvert\Model\Node\Type as NodeType;

class NumberLiteral extends NodeType {

    private $value = '';

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getValue($value) {
        return $this->value;
    }

}
