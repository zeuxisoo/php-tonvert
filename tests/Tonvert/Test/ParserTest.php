<?php
namespace Tonvert\Test;

use Tonvert\{ TestCase, Tokenizer, Parser };
use Tonvert\Model\Node;

class ParserTest extends TestCase {

    public function testTake() {
        $tokenizer = new Tokenizer();
        $tokenes   = $tokenizer->take(__DIR__."/Fixtures/default.txt");

        $parser = new Parser();
        $ast    = $parser->parse($tokenes);

        $root = Node::factory(Node::TYPE_PROGRAM);
        $root->addBody(
            Node::factory(Node::TYPE_CALL_EXPRESSION)
                ->setName("subtract")
                ->setParams([
                    Node::factory(Node::TYPE_NUMBER_LITERAL)->setValue(2017),
                    Node::factory(Node::TYPE_STRING_LITERAL)->setValue("ff68"),
                    Node::factory(Node::TYPE_CALL_EXPRESSION)
                        ->setName("add")
                        ->setParams([
                            Node::factory(Node::TYPE_NUMBER_LITERAL)->setValue(6),
                            Node::factory(Node::TYPE_NUMBER_LITERAL)->setValue(10),
                        ])
                ])
        );

        $this->assertEquals($root, $ast);
    }

}
