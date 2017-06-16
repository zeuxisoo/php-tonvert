<?php
namespace Tonvert\Model\TransformedNote;

use Tonvert\Model\TransformedNote\Type as TransformedNoteType;

class Program extends TransformedNoteType {

    private $body = [];

    public function addBody(TransformedNoteType $body) {
        array_push($this->body, $body);
    }

    public function getBody() {
        return $this->body;
    }

}
