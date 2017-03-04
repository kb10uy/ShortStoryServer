<?php

namespace App\Utilities\Parsers;

class Rule 
{
    public $start = '';
    public $end = '';
    public $callback;

    /*
     * callbackの仕様
     * function (ParserState $state, string match) : string
     *
     *
     */
}