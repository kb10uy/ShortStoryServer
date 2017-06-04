<?php

namespace App\Utilities\Parsers;
abstract class Parser 
{
    // @return ['text' => '変換済み本文', 'anchors' => [['display-text', 'anchor-name'], ['2', 'two'], ...]]
    abstract public function parse(string $text);

    // @return 本文のみ
    abstract public function parseToPlain(string $text);
}