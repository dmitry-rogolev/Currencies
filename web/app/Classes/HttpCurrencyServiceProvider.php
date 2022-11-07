<?php

namespace App\Classes;

use Exception;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

/**
 * Предоставляет данные о валютах через http
 */
class HttpCurrencyServiceProvider
{
    /**
     * Даные о валютах
     *
     * @var string
     */
    private string $data;

    /**
     * Название конфига валют
     */
    private const CONFIG_NAME = "currency";

    /**
     * Название конфига для источника валют
     */
    private const CONFIG_SOURCE_NAME = self::CONFIG_NAME . ".source";

    /**
     * Количество попыток получения данных через http
     */
    private const COUNT_TRY_TO_CONNECT = 5;

    /**
     * Загружает данные о валютах
     *
     * @return App\Classes\HttpCurrencyServiceProvider
     */
    public static function boot()
    {
        $provider = new self;

        return $provider;
    }

    /**
     * Возвращает данные
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Возвращает данные в виде xml
     *
     * @return SimpleXMLElement
     */
    public function getXml()
    {
        return new SimpleXMLElement($this->data);
    }

    /**
     * Получает данные с сервера
     *
     * @return string
     */
    private function get()
    {
        $try = 0;

        while (true)
        {
            try {
                $data = file_get_contents(config(self::CONFIG_SOURCE_NAME));
                Log::info("Получены данные о валютах");
                break;
            }
            catch (Exception $e) {
                if ($try > self::COUNT_TRY_TO_CONNECT) throw $e;
                $try++;
                continue;
            }
        }

        return $data;
    }

    private function __construct()
    {
        $this->data = $this->get();
    }
}
