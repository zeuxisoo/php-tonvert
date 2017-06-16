<?php
namespace Tonvert\Model;

class TransformedNote {

    const TYPE_PROGRAM              = 'program';
    const TYPE_EXPRESSION_STATEMENT = 'expression_statement';
    const TYPE_CALL_EXPRESSION      = 'call_expression';
    const TYPE_STRING_LITERAL       = 'string_literal';
    const TYPE_NUMBER_LITERAL       = 'number_literal';

    public static function factory($type) {
        $name = "";

        switch($type) {
            case static::TYPE_PROGRAM:
                $name = "Program";
                break;
            case static::TYPE_NUMBER_LITERAL:
                $name = "NumberLiteral";
                break;
            case static::TYPE_STRING_LITERAL:
                $name = "StringLiteral";
                break;
            case static::TYPE_EXPRESSION_STATEMENT:
                $name = "ExpressionStatement";
                break;
            case static::TYPE_CALL_EXPRESSION:
                $name = "CallExpression";
                break;
        }

        $className = __namespace__."\\TransformedNote\\".$name;

        return new $className();
    }

}