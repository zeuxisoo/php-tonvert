<?php
namespace Tonvert;

use Tonvert\Model\Node\Type as NodeType;
use Tonvert\Model\Node\Program as NodeProgram;
use Tonvert\Model\Node\NumberLiteral as NodeNumberLiteral;
use Tonvert\Model\Node\StringLiteral as NodeStringLiteral;
use Tonvert\Model\Node\CallExpression as NodeCallExpression;
use Tonvert\Model\TransformedNode;

class Transformer {

    const VISITOR_ENTER = 'enter';
    const VISITOR_EXIT  = 'exit';

    public function transform(NodeType $ast) {
        $newAst   = TransformedNode::factory(TransformedNode::TYPE_PROGRAM);
        $body     = null;
        $visitors = [
            NodeNumberLiteral::class => [
                static::VISITOR_ENTER => function(NodeType $node, $parent, &$body) {
                    if ($node instanceof NodeNumberLiteral) {
                        $addArgumentAction = $parent->_addArgumentAction;
                        $addArgumentAction(
                            TransformedNode::factory(TransformedNode::TYPE_NUMBER_LITERAL)
                                ->setValue($node->getValue())
                        );
                    }
                },

                static::VISITOR_EXIT => null,
            ],

            NodeStringLiteral::class => [
                static::VISITOR_ENTER => function(NodeType $node, $parent, &$body) {
                    if ($node instanceof NodeStringLiteral) {
                        $addArgumentAction = $parent->_addArgumentAction;
                        $addArgumentAction(
                            TransformedNode::factory(TransformedNode::TYPE_STRING_LITERAL)
                                ->setValue($node->getValue())
                        );
                    }
                },

                static::VISITOR_EXIT => null,
            ],

            NodeCallExpression::class => [
                static::VISITOR_ENTER => function(NodeType $node, $parent, &$body) {
                    if ($node instanceof NodeCallExpression) {
                        $expression = TransformedNode::factory(TransformedNode::TYPE_CALL_EXPRESSION)
                                        ->setCallee($node->getName())
                                        ->setArguments([]);

                        // Create dynamically method in current node object
                        // - provide a way for the childen node to add itself to the current node to become his arguments
                        // - childen node like StringLiteral, NumberLiteral
                        $node->_addArgumentAction = function($argument) use ($expression) {
                            $expression->addArgument($argument);
                        };

                        // If the parent is CallExpression node, make it to become arguments
                        if ($parent instanceof NodeCallExpression) {
                            $addArgumentAction = $parent->_addArgumentAction;
                            $addArgumentAction($expression);
                        }

                        // If the parent is not CallExpression node, so all node should under it
                        if (($parent instanceof NodeCallExpression) === false) {
                            $expression = TransformedNode::factory(TransformedNode::TYPE_EXPRESSION_STATEMENT)
                                            ->setExpression($expression);

                            // Update the new ast body once
                            $body = $expression;
                        }
                    }
                },

                static::VISITOR_EXIT => null,
            ]
        ];

        $this->traverser($ast, $body, $visitors);

        $newAst->addBody($body);

        return $newAst;
    }

    private function traverser($node, &$body, $visitors) {
        $this->traverseNode($node, null, $body, $visitors);
    }

    private function traverseNode($node, $parent, &$body, $visitors) {
        $nodeName = get_class($node);

        if (array_key_exists($nodeName, $visitors) === true) {
            $visitor     = $visitors[$nodeName];
            $enterAction = $visitor[static::VISITOR_ENTER];

            if (is_callable($enterAction) === true) {
                $enterAction($node, $parent, $body);
            }
        }

        //
        if ($node instanceof NodeProgram) {
            $this->traverseNodes($node->getBody(), $node, $body, $visitors);
        }

        if ($node instanceof NodeCallExpression) {
            $this->traverseNodes($node->getParams(), $node, $body, $visitors);
        }

        //
        if (array_key_exists($nodeName, $visitors) === true) {
            $visitor     = $visitors[$nodeName];
            $exitAction = $visitor[static::VISITOR_EXIT];

            if (is_callable($exitAction) === true) {
                $exitAction($node, $parent, $body);
            }
        }
    }

    private function traverseNodes($nodes, $parent, &$body, $visitors) {
        if (is_array($nodes) === true) {
            foreach($nodes as $node) {
                $this->traverseNode($node, $parent, $body, $visitors);
            }
        }
    }

}
