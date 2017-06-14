<?php
namespace Tonvert\Model\Node;

class Program extends Type {

    private $body = [];

    public function addBody($body) {
        array_push($this->body, $body);
    }

    public function getBody() {
        return $this->body;
    }

}
