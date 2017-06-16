<?php
namespace Tonvert\Model\TransformedNode;

use Tonvert\Model\TransformedNode\Type as TransformedNodeType;

class CallExpression extends TransformedNodeType {

    private $callee    = '';
    private $arguments = [];

    public function setCallee($callee) {
        $this->callee = $callee;
        return $this;
    }

    public function setArguments(array $arguments) {
        $this->arguments = $arguments;
        return $this;
    }

    public function getCallee() {
        return $this->callee;
    }

    public function getArguments() {
        return $this->arguments;
    }

    public function addArgument($argument) {
        array_push($this->arguments, $argument);
        return $this;
    }

    public function __call($method, $args) {
        echo $method,"\n";
        exit;
    }

}
