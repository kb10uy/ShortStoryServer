<?php

namespace App\Utilities;

use App\Utilities\Parsers\S3wfParser;
use App\Utilities\Parsers\PlainParser;

class TextParser 
{
    protected $parsers = [];

    function __construct()
    {
        $this->parsers['s3wf'] = new S3wfParser;
        $this->parsers['plain'] = new PlainParser;
    }

    public function parse(string $type, string $text)
    {
        return $this->parsers[$type]->parse(htmlspecialchars($text));
    }

    public function parseToPlain(string $type, string $text)
    {
        return $this->parsers[$type]->parseToPlain(htmlspecialchars($text));
    }
}