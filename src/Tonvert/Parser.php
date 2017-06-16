<?php
namespace Tonvert;

use ArrayIterator;
use Tonvert\Model\{ Token, Node };
use Tonvert\Model\Node\Type as NodeType;

class Parser {

    public function parse(array $tokenes): NodeType {
        $ast = Node::factory(Node::TYPE_PROGRAM);

        $tokenGenerator = $this->toTokenGenerator($tokenes);

        while($tokenGenerator->valid() === true) {
            $token = $tokenGenerator->current();

            $ast->addBody($this->walk($token, $tokenGenerator));

            $tokenGenerator->next();
        }

        return $ast;
    }

    private function toTokenGenerator($tokenes) {
        yield from new ArrayIterator($tokenes);
    }

    private function walk($token, $tokenGenerator) {
        if ($token->getName() === Token::TYPE_NUMBER) {
            return Node::factory(Node::TYPE_NUMBER_LITERAL)->setValue($token->getValue());
        }

        if ($token->getName() === Token::TYPE_STRING) {
            return Node::factory(Node::TYPE_STRING_LITERAL)->setValue($token->getValue());
        }

        if ($token->getName() === Token::TYPE_PARENTHESES_OPEN) {
            // Skip the open parenthes
            $tokenGenerator->next();

            // Get current token
            $token = $tokenGenerator->current();

            if ($token->getName() === Token::TYPE_NAME) {
                $params = [];

                // Skip the current token name and enter to looping nodes
                $tokenGenerator->next();

                while($tokenGenerator->valid() === true) {
                    $subToken = $tokenGenerator->current();

                    // Skip the close parenthes
                    if ($subToken->getName() === Token::TYPE_PARENTHESES_CLOSE) {
                        $tokenGenerator->next();
                        continue;
                    }

                    array_push($params, $this->walk($subToken, $tokenGenerator));

                    $tokenGenerator->next();
                }

                // Skip the close parenthes
                $tokenGenerator->next();

                return Node::factory(Node::TYPE_CALL_EXPRESSION)
                        ->setName($token->getValue())
                        ->setParams($params);
            }
        }
    }

}
