<?php
namespace Tonvert;

use ArrayIterator;
use Tonvert\Model\Token;

class Parser {

    public function parse(array $tokenes) {
        $ast = [
            'type' => 'Program',
            'body' => [],
        ];

        $tokenGenerator = $this->toTokenGenerator($tokenes);

        while($tokenGenerator->valid() === true) {
            $token = $tokenGenerator->current();

            array_push($ast['body'], $this->walk($token, $tokenGenerator));

            $tokenGenerator->next();
        }

        return $ast;
    }

    private function toTokenGenerator($tokenes) {
        yield from new ArrayIterator($tokenes);
    }

    private function walk($token, $tokenGenerator) {
        if ($token->getName() === Token::TYPE_NUMBER) {
            return [
                'type'  => 'NumberLiteral',
                'value' => $token->getValue(),
            ];
        }

        if ($token->getName() === Token::TYPE_STRING) {
            return [
                'type'  => 'StringLiteral',
                'value' => $token->getValue(),
            ];
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

                return [
                    'type' => 'CallExpression',
                    'name' => $token->getValue(),
                    'params' => $params,
                ];
            }
        }
    }

}
