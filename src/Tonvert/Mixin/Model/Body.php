<?php
namespace Tonvert\Mixin\Model;

trait Body {

    private $body = [];

    public function addBody($body) {
        array_push($this->body, $body);
    }

    public function getBody() {
        return $this->body;
    }

}
