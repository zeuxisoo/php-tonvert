<?php
namespace Tonvert;

use Tonvert\Model\Token;

class Tokenizer {

    public function take(string $inPath): array {
        $tokenes       = [];
        $charGenerator = $this->toCharGenerator($inPath);

        while($charGenerator->valid() === true) {
            $char = $charGenerator->current();

            if ($this->isWhiteSpace($char) == true) {
                $charGenerator->next();
                continue;
            }

            if ($this->isParenthesesOpen($char) == true) {
                array_push($tokenes, new Token(Token::TYPE_PARENTHESES_OPEN, '('));
                $charGenerator->next();
                continue;
            }

            if ($this->isParenthesesClose($char) == true) {
                array_push($tokenes, new Token(Token::TYPE_PARENTHESES_CLOSE, ')'));
                $charGenerator->next();
                continue;
            }

            if ($this->isAlphabet($char) == true) {
                $alphabets = [];

                while($this->isAlphabet($char) == true) {
                    array_push($alphabets, $char);

                    $charGenerator->next();

                    $char = $charGenerator->current();
                }

                array_push($tokenes, new Token(Token::TYPE_NAME, implode('', $alphabets)));

                continue;
            }

            if ($this->isNumber($char) == true) {
                $numbers = [];

                while($this->isNumber($char) == true) {
                    array_push($numbers, $char);

                    $charGenerator->next();

                    $char = $charGenerator->current();
                }

                array_push($tokenes, new Token(Token::TYPE_NUMBER, implode('', $numbers)));

                continue;
            }

            if ($this->isDoubleQuote($char) == true) {
                $text = [];

                // Skip open doublue quote
                $charGenerator->next();

                // Start record string
                $char = $charGenerator->current();

                while($char != '"') {
                    array_push($text, $char);

                    $charGenerator->next();

                    $char = $charGenerator->current();
                }

                array_push($tokenes, new Token(Token::TYPE_STRING, implode('', $text)));

                // Skip close double quote
                $charGenerator->next();

                continue;
            }

            throw new Exception("I don't know what this character is: {$char} (ascii: ".ord($char).")");
        }

        return $tokenes;
    }

    private function toCharGenerator($inFile) {
        $file = fopen($inFile, 'r');
        while(($char = fgetc($file)) !== false) {
            yield $char;
        }
        fclose($file);
    }

    private function isWhiteSpace($char): int {
        return preg_match('/\s/', $char);
    }

    private function isParenthesesOpen($char): bool {
        return $char === '(';
    }

    private function isParenthesesClose($char): bool {
        return $char === ')';
    }

    private function isAlphabet($char): int {
        return preg_match('/[a-z]/i', $char);
    }

    private function isNumber($char): int {
        return preg_match('/[0-9]/', $char);
    }

    private function isDoubleQuote($char): bool {
        return $char === '"';
    }

}
