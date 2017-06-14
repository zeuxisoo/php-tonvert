<?php
namespace Tonvert\Model\Node;

use Tonvert\Model\Node\Type as NodeType;

class Program extends NodeType {

    private $body = [];

    public function addBody(NodeType $body) {
        array_push($this->body, $body);
    }

    public function getBody() {
        return $this->body;
    }

}
