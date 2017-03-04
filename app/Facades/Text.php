<?php

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class Text extends Facade 
{
    protected static function getFacadeAccessor() 
    {
        return 'text';
    }
}