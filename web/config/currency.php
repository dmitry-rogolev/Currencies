<?php

return [

    // Источник данных 
    "source" => env("CURRENCY_SOURCE", "http://www.cbr.ru/scripts/XML_daily.asp"), 

    // Интервал обновлений данных в секундах по умолчанию
    "default_interval" => intval(env("CURRENCY_UPLOAD_DEFAULT_INTERVAL", 3600)), 

];
