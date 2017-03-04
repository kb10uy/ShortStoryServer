<?php

namespace App\Utilities;

use Parsers\S3wfParser;

class TextParser 
{
    protected $parsers = [];

    public function __construct()
    {
        $parsers['s3wf'] = new S3wfParser;
    }

    public function parse(string $type, string $text)
    {
        return $this->parsers[$type]->parse(htmlspecialchars($text));
    }
}