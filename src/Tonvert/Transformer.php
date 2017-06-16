<?php
namespace Tonvert;

use Tonvert\Model\Node\Type as NodeType;
use Tonvert\Model\Node\Program as NodeProgram;
use Tonvert\Model\Node\NumberLiteral as NodeNumberLiteral;
use Tonvert\Model\Node\StringLiteral as NodeStringLiteral;
use Tonvert\Model\Node\CallExpression as NodeCallExpression;
use Tonvert\Model\Node;

class Transformer {

    const VISITOR_ENTER = 'enter';
    const VISITOR_EXIT  = 'exit';

    public function transform(NodeType $ast) {
        $body     = [];
        $visitors = [
            NodeNumberLiteral::class => [
                static::VISITOR_ENTER => function(NodeType $node, $parent, &$body) {
                    if ($node instanceof NodeNumberLiteral) {
                        array_push($parent->_refArguments, [
                            'type' => 'NumberLiteral',
                            'value' => $node->getValue()
                        ]);
                    }
                },

                static::VISITOR_EXIT => null,
            ],

            NodeStringLiteral::class => [
                static::VISITOR_ENTER => function(NodeType $node, $parent, &$body) {
                    if ($node instanceof NodeStringLiteral) {
                        array_push($parent->_refArguments, [
                            'type' => 'StringLiteral',
                            'value' => $node->getValue()
                        ]);
                    }
                },

                static::VISITOR_EXIT => null,
            ],

            NodeCallExpression::class => [
                static::VISITOR_ENTER => function(NodeType $node, $parent, &$body) {
                    if ($node instanceof NodeCallExpression) {
                        $expression = [
                            'type'      => 'CallExpression',
                            'callee'    => $node->getName(),
                            'arguments' => []
                        ];

                        // Create dynamically class member
                        // - make it reference to $expression arguments options.
                        // - provide a way for sub-node (like: StringLiteral, NumberLiteral) to push arguments
                        $node->_refArguments = &$expression['arguments'];

                        // If the parent is CallExpression node, make it to arguments
                        if ($parent instanceof NodeCallExpression) {
                            array_push($parent->_refArguments, $expression);
                        }

                        // If the parent is not CallExpression node, so all node should under it
                        if (($parent instanceof NodeCallExpression) === false) {
                            $expression = [
                                'type'       => 'ExpressionStatement',
                                'expression' => $expression,
                            ];

                            // Update the new ast body once
                            array_push($body, $expression);
                        }
                    }
                },

                static::VISITOR_EXIT => null,
            ]
        ];

        $this->traverser($ast, $body, $visitors);

        return $body;
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
