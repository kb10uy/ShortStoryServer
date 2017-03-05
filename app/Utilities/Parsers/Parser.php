<?php

namespace App\Utilities\Parsers;
abstract class Parser 
{
    abstract public function parse(string $text);
    abstract public function parseToPlain(string $text);
}