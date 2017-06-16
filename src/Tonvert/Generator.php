<?php
namespace Tonvert;

use Tonvert\Model\TransformedNode\{
    Type as TransformedNodeType,
    Program as TransformedNodeProgram,
    ExpressionStatement as TransformedNodeExpressionStatement,
    CallExpression as TransformedNodeCallExpression,
    Identifier as TransformedNodeIdentifier,
    NumberLiteral as TransformedNodeNumberLiteral,
    StringLiteral as TransformedNodeStringLiteral
};

class Generator {

    public function generate(TransformedNodeType $node) {
        if ($node instanceof TransformedNodeProgram) {
            return array_map([$this, 'generate'], $node->getBody())[0];
        }

        if ($node instanceof TransformedNodeExpressionStatement) {
            return $this->generate($node->getExpression());
        }

        if ($node instanceof TransformedNodeCallExpression) {
            return sprintf(
                "%s(%s)",
                $this->generate($node->getCallee()),
                implode(", ", array_map([$this, 'generate'], $node->getArguments()))
            );
        }

        if ($node instanceof TransformedNodeIdentifier) {
            return $node->getName();
        }

        if ($node instanceof TransformedNodeNumberLiteral) {
            return $node->getValue();
        }

        if ($node instanceof TransformedNodeStringLiteral) {
            return '"'.$node->getValue().'"';
        }
    }

}
