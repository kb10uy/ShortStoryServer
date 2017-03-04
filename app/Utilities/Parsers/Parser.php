<?php

namespace App\Utilities\Parsers;

use Rule;

abstract class Parser 
{
    abstract public function parse(string $text);
}