<?php
namespace Tonvert\Mixin\Model;

trait Value {

    private $value = '';

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

}
