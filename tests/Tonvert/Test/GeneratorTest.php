<?php
namespace Tonvert\Test;

use Tonvert\TestCase;
use Tonvert\Tokenizer;
use Tonvert\Parser;
use Tonvert\Transformer;
use Tonvert\Generator;

class GeneratorTest extends TestCase {

    public function testGenerate() {
        $tokenes   = (new Tokenizer())->take(__DIR__."/Fixtures/default.txt");
        $ast       = (new Parser())->parse($tokenes);
        $newAst    = (new Transformer())->transform($ast);
        $generated = (new Generator())->generate($newAst);

        $this->assertEquals('subtract(2017, "ff68", add(6, 10))', $generated);
    }

}
