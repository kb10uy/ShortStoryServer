<?php

namespace App\Utilities;

use App\Utilities\Parsers\S3wfParser;

class TextParser 
{
    protected $parsers = [];

    function __construct()
    {
        $this->parsers['s3wf'] = new S3wfParser;
    }

    public function parse(string $type, string $text)
    {
        return $this->parsers[$type]->parse(htmlspecialchars($text));
    }
}