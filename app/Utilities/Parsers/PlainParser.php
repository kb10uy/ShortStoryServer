<?php
namespace App\Utilities\Parsers;

use App\Utilities\Parsers\Parser;

class PlainParser extends Parser
{
    public function __construct()
    {
    }

    //htmlspecialcharsを通した文字列が渡されます
    public function parse(string $text)
    {
        $lines = preg_split('/\R/u', $text, -1);
        $state = [];
        $result = [];
        
        foreach($lines as $line) {
            $line += '<br>';
            $result[] = $line;
        }
        return implode("\n", $result); 
    }

    public function parseToPlain(string $text)
    {
        return $text;
    }
}