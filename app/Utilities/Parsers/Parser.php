<?php

namespace App\Utilities\Parsers;

use Rule;

abstract class Parser 
{
    protected $inlineRules = [];
    protected $regexRules = [];
    protected $lineRules = [];
    protected $blockRules = [];

    public function inlineRule(string $start, string $end, callable $callback) 
    {
        $rule = new Rule;
        $rule->start = $start;
        $rule->end = $end;
        $rule->callback = $callback;
        $inlineRules[] = $rule;
    }
    
    public function regexRule(string $expr, callable $callback)
    {
        $rule = new Rule;
        $rule->start = $expr;
        $rule->callback = $callback;
        $regexRules[] = $rule;
    }

    public function lineRule(string $start, callable $callback)
    {
        $rule = new Rule;
        $rule->start = $start;
        $rule->callback = $callback;
        $lineRules[] = $rule;
    }

    public function blockRule(string $start, string $end, callable $callback)
    {
        $rule = new Rule;
        $rule->start = $start;
        $rule->end = $end;
        $rule->callback = $callback;
        $blockRules[] = $rule;
    }

    abstract public function initParse();
    abstract public function parseLine();

}