<?php

namespace App\Utilities;
use Agent;

class ViewExtra
{
    public static $suffixMobile = '-m';

    public static function drawOnDevice(string $name, array $data = null)
    {
        if (Agent::isMobile()) {
            return view($name . $this->suffixMobile, $data);
        } else {
            return view($name, $data);
        }
    }
}