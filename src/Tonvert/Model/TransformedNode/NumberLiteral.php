<?php
namespace Tonvert\Model\TransformedNode;

use Tonvert\Model\TransformedNode\Type as TransformedNodeType;
use Tonvert\Mixin\Model\Value as ModelValue;

class NumberLiteral extends TransformedNodeType {

    use ModelValue;

}
