<?php
namespace Tonvert\Model;

class Token {

    const TYPE_PARENTHESES_OPEN  = 'parentheses_open';
    const TYPE_PARENTHESES_CLOSE = 'parentheses_close';
    const TYPE_DOUBLE_QUOTE      = 'double_quote';
    const TYPE_NAME              = 'name';
    const TYPE_NUMBER            = 'number';
    const TYPE_STRING            = 'string';

    private $name;
    private $value;

    public function __construct($name, $value) {
        $this->name  = $name;
        $this->value = $value;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getName() {
        return $this->name;
    }

    public function getValue() {
        return $this->value;
    }

}
