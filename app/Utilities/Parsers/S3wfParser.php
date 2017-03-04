<?php

namespace App\Utilities\Parsers;

use kb10uy\S3\Parsers\Parser;

class S3wfParser extends Parser
{
    public function __construct()
    {
        $this->registerInlineRule();
        $this->registerRegexRule();
        $this->registerLineRule();
        $this->registerBlockRule();
    }

    public function initParse()
    {

    }
    
    public function parseLine()
    {

    }

    // register ---------------------------------
    private function registerInlineRule()
    {
        
    }

    private function registerRegexRule()
    {

    }

    private function registerLineRule()
    {
        
    }

    private function registerBlockRule()
    {

    }
}