<?php
namespace Tonvert;

use ArrayIterator;
use Tonvert\Model\{ Token, Node };
use Tonvert\Model\Node\Type as NodeType;

class Parser {

    public function parse(array $tokenes): NodeType {
        $ast            = Node::factory(Node::TYPE_PROGRAM);
        $tokenGenerator = $this->toTokenGenerator($tokenes);

        while($tokenGenerator->valid() === true) {
            $token = $tokenGenerator->current();

            $ast->addBody($this->walk($token, $tokenGenerator));
        }

        return $ast;
    }

    private function toTokenGenerator($tokenes) {
        yield from new ArrayIterator($tokenes);
    }

    private function walk($token, $tokenGenerator) {
        if ($token->getName() === Token::TYPE_NUMBER) {
            $tokenGenerator->next();

            return Node::factory(Node::TYPE_NUMBER_LITERAL)->setValue($token->getValue());
        }

        if ($token->getName() === Token::TYPE_STRING) {
            $tokenGenerator->next();

            return Node::factory(Node::TYPE_STRING_LITERAL)->setValue($token->getValue());
        }

        if ($token->getName() === Token::TYPE_PARENTHESES_OPEN) {
            // Skip the open parenthes
            $tokenGenerator->next();

            // Get the current token
            $token = $tokenGenerator->current();

            // Create call expression node with current token
            $node = Node::factory(Node::TYPE_CALL_EXPRESSION)
                ->setName($token->getValue())
                ->setParams([]);

            // Enter to the next token
            $tokenGenerator->next();

            $token = $tokenGenerator->current();

            // loop the context until not in the parentheses or until reach parenthes close
            $isParenthes = (
                $token->getName() !== Token::TYPE_PARENTHESES_OPEN ||
                $token->getName() !== Token::TYPE_PARENTHESES_CLOSE
            );

            while(
                $isParenthes === false ||
                $token->getName() !== Token::TYPE_PARENTHESES_CLOSE
            ) {
                $node->addParams($this->walk($token, $tokenGenerator));
                $token = $tokenGenerator->current();
            }

            $tokenGenerator->next();

            return $node;
        }

        throw new Exception(sprintf(
            "I don't know what this token is or this is a token should not be covered: %s",
            $token
        ));
    }

}
