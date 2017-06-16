<?php
namespace Tonvert\Model\TransformedNote;

use Tonvert\Model\TransformedNote\Type as TransformedNoteType;

class ExpressionStatement extends TransformedNoteType {

    private $expression;

    public function setExpression($expression) {
        $this->expression = $expression;
        return $this;
    }

    public function getExpression() {
        return $this->expression;
    }

}
