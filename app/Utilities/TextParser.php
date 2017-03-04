<?php

namespace App\Utilities;

class TextParser 
{
    protected $parser;

    public function __construct()
    {
        $parser = new TextParser;
    }

    public function parse(string $type, string $text)
    {
        return $this->parser->parse($type, $text);
    }
}