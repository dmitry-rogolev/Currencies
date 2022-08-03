<?php

use Illuminate\Support\Str;

if (!function_exists("id"))
{
    /**
     * Возвращает идентификатор в виде строки
     *
     * @param integer $length Количество символов с строке без учета префикса
     * @param string $prefix Префикс
     * @return string
     */
    function id(int $length = 60, string $prefix = "id_") : string
    {
        return $prefix . Str::random($length);
    }
}
