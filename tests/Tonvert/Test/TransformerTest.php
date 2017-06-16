<?php
namespace Tonvert\Test;

use Tonvert\TestCase;
use Tonvert\Tokenizer;
use Tonvert\Parser;
use Tonvert\Transformer;
use Tonvert\Model\TransformedNode;

class TransformerTest extends TestCase {

    public function testTransform() {
        $tokenizer = new Tokenizer();
        $tokenes   = $tokenizer->take(__DIR__."/Fixtures/default.txt");

        $parser = new Parser();
        $ast    = $parser->parse($tokenes);

        $transformer = new Transformer();
        $newAst      = $transformer->transform($ast);

        $root = TransformedNode::factory(TransformedNode::TYPE_PROGRAM);
        $root->addBody(
            TransformedNode::factory(TransformedNode::TYPE_EXPRESSION_STATEMENT)
                ->setExpression(
                    TransformedNode::factory(TransformedNode::TYPE_CALL_EXPRESSION)
                        ->setCallee(
                            TransformedNode::factory(TransformedNode::TYPE_IDENTIFIER)->setName("subtract")
                        )
                        ->setArguments([
                            TransformedNode::factory(TransformedNode::TYPE_NUMBER_LITERAL)->setValue(2017),
                            TransformedNode::factory(TransformedNode::TYPE_STRING_LITERAL)->setValue("ff68"),
                            TransformedNode::factory(TransformedNode::TYPE_CALL_EXPRESSION)
                                ->setCallee(
                                    TransformedNode::factory(TransformedNode::TYPE_IDENTIFIER)->setName("add")
                                )
                                ->setArguments([
                                    TransformedNode::factory(TransformedNode::TYPE_NUMBER_LITERAL)->setValue(6),
                                    TransformedNode::factory(TransformedNode::TYPE_NUMBER_LITERAL)->setValue(10),
                                ])
                        ])
                )
        );

        $this->assertEquals($root, $newAst);
    }

}
