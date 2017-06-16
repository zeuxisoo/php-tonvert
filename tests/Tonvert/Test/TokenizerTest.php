<?php
namespace Tonvert\Test;

use Tonvert\{ TestCase, Tokenizer };
use Tonvert\Model\Token;

class TokenizerTest extends TestCase {

    public function testTake() {
        $tokenizer = new Tokenizer();
        $tokenes   = $tokenizer->take(__DIR__."/Fixtures/default.txt");

        $this->assertEquals([
            new Token(Token::TYPE_PARENTHESES_OPEN, '('),
            new Token(Token::TYPE_NAME, 'subtract'),
            new Token(Token::TYPE_NUMBER, '2017'),
            new Token(Token::TYPE_STRING, 'ff68'),
            new Token(Token::TYPE_PARENTHESES_OPEN, '('),
            new Token(Token::TYPE_NAME, 'add'),
            new Token(Token::TYPE_NUMBER, '6'),
            new Token(Token::TYPE_NUMBER, '10'),
            new Token(Token::TYPE_PARENTHESES_CLOSE, ')'),
            new Token(Token::TYPE_PARENTHESES_CLOSE, ')'),
        ], $tokenes);
    }

}
