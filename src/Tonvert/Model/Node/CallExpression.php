<?php
namespace Tonvert\Model\Node;

use Tonvert\Model\Node\Type as NodeType;

class CallExpression extends NodeType {

    private $name   = '';
    private $params = [];

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setParams(array $params) {
        $this->params = $params;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function getParams() {
        return $this->params;
    }

}
