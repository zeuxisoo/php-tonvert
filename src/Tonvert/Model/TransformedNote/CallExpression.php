<?php
namespace Tonvert\Model\TransformedNote;

use Tonvert\Model\TransformedNote\Type as TransformedNoteType;

class CallExpression extends TransformedNoteType {

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
