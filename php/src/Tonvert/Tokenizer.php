<?php
namespace Tonvert;

use Tonvert\Model\Token;

class Tokenizer {

    public function take(string $inPath) {
        $tokenes       = [];
        $content       = trim(file_get_contents($inPath));
        $current       = 0;
        $contentLength = strlen($content);

        while($current < $contentLength) {
            $char = $content[$current];

            if ($this->isWhiteSpace($char) == true) {
                $current++;
                continue;
            }

            if ($this->isParenthesesOpen($char) == true) {
                array_push($tokenes, new Token(Token::TYPE_PARENTHESES_OPEN, '('));
                $current++;
                continue;
            }

            if ($this->isParenthesesClose($char) == true) {
                array_push($tokenes, new Token(Token::TYPE_PARENTHESES_CLOSE, ')'));
                $current++;
                continue;
            }

            if ($this->isAlphabet($char) == true) {
                $alphabets = [];

                while($this->isAlphabet($char) == true) {
                    array_push($alphabets, $char);
                    $char = $content[++$current];
                }

                array_push($tokenes, new Token(Token::TYPE_NAME, implode('', $alphabets)));

                continue;
            }

            if ($this->isNumber($char) == true) {
                $numbers = [];

                while($this->isNumber($char) == true) {
                    array_push($numbers, $char);
                    $char = $content[++$current];
                }

                array_push($tokenes, new Token(Token::TYPE_NUMBER, implode('', $numbers)));

                continue;
            }

            if ($this->isDoubleQuote($char) == true) {
                $text = [];                     // Skip open doublue quote
                $char = $content[++$current];   // Start record string

                while($char != '"') {
                    array_push($text, $char);
                    $char = $content[++$current];
                }

                array_push($tokenes, new Token(Token::TYPE_STRING, implode('', $text)));

                $current++; // Skip close double quote

                continue;
            }

            throw new Exception("I don't know what this character is: {$char} (ascii: ".ord($char).")");
        }

        return $tokenes;
    }

    private function isWhiteSpace($char) {
        return preg_match('/\s/', $char);
    }

    private function isParenthesesOpen($char) {
        return $char === '(';
    }

    private function isParenthesesClose($char) {
        return $char === ')';
    }

    private function isAlphabet($char) {
        return preg_match('/[a-z]/i', $char);
    }

    private function isNumber($char) {
        return preg_match('/[0-9]/', $char);
    }

    private function isDoubleQuote($char) {
        return $char === '"';
    }

}
