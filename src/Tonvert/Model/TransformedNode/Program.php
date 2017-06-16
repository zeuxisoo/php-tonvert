<?php
namespace Tonvert\Model\TransformedNode;

use Tonvert\Model\TransformedNode\Type as TransformedNodeType;

class Program extends TransformedNodeType {

    private $body = [];

    public function addBody(TransformedNodeType $body) {
        array_push($this->body, $body);
    }

    public function getBody() {
        return $this->body;
    }

}
