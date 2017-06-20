<?php
namespace Tonvert\Mixin\Model;

trait Body {

    private $body = [];

    public function addBody($body) {
        array_push($this->body, $body);
        return $this;
    }

    public function getBody() {
        return $this->body;
    }

    public function setBody($body) {
        $this->body = $body;
        return $this;
    }

}
