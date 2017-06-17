<?php
namespace Tonvert\Mixin\Model;

trait Name {

    private $name = '';

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

}
