<?php
namespace Tonvert\Model\TransformedNode;

use Tonvert\Model\TransformedNode\Type as TransformedNodeType;

class ExpressionStatement extends TransformedNodeType {

    private $expression;

    public function setExpression($expression) {
        $this->expression = $expression;
        return $this;
    }

    public function getExpression() {
        return $this->expression;
    }

}
