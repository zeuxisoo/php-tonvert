<?php
namespace Tonvert\Model\TransformedNote;

use Tonvert\Model\TransformedNote\Type as TransformedNoteType;

class StringLiteral extends TransformedNoteType {

    private $value = '';

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

}
