<?php
namespace Tonvert\Model;

class Node {

    const TYPE_PROGRAM         = 'program';
    const TYPE_CALL_EXPRESSION = 'call_expression';
    const TYPE_STRING_LITERAL  = 'string_literal';
    const TYPE_NUMBER_LITERAL  = 'number_literal';

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
            case static::TYPE_CALL_EXPRESSION:
                $name = "CallExpression";
                break;
        }

        $className = __namespace__."\\Node\\".$name;

        return new $className();
    }

}
