<?php
namespace Tonvert\Model\Node;

use Tonvert\Model\Node\Type as NodeType;
use Tonvert\Mixin\Model\Name as ModelName;

class CallExpression extends NodeType {

    use ModelName;

    private $params = [];

    public function setParams(array $params) {
        $this->params = $params;
        return $this;
    }

    public function getParams() {
        return $this->params;
    }

}
