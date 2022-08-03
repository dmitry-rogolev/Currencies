<?php

use Illuminate\Support\Str;

if (!function_exists("id"))
{
    function id(int $length = 60, string $prefix = "id_")
    {
        return $prefix . Str::random($length);
    }
}
