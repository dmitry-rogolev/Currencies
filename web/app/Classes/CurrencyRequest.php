<?php

namespace App\Classes;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * Предоставляет функционал получения данных от клиента
 */
class CurrencyRequest
{
    /**
     * Валюты, которые необходимо загружать
     *
     * @var Illuminate\Support\Collection
     */
    private Collection $loads;

    /**
     * Валюты, которые необходимо отображать
     *
     * @var Illuminate\Support\Collection
     */
    private Collection $visibles;

    /**
     * Интервал обновления данных
     *
     * @var integer
     */
    private int $interval;

    /**
     * Префикс для сессии
     */
    private const PREFIX_FOR_NAME_OF_SESSION = "currencies_";

    /**
     * Название в сессии интервала обновления данных
     */
    private const NAME_SESSION_INTERVAL = self::PREFIX_FOR_NAME_OF_SESSION . "interval_update_data";

    /**
     * Название конфига валют
     */
    private const CONFIG_NAME = "currency";

    /**
     * Название конфига интервала по умолчанию
     */
    private const CONFIG_DEFAULT_INTERVAL = self::CONFIG_NAME . ".default_interval";

    public function __construct()
    {
        $this->loads = $this->loads();
        $this->interval = $this->interval();
        $this->visibles = $this->visibles();
    }

    /**
     * Возвращает валюты, которые необходимо загружать
     *
     * @return Illuminate\Support\Collection
     */
    public function getLoads()
    {
        return $this->loads;
    }

    /**
     * Возвращает валюты, которые необходимо отображать
     *
     * @return Illuminate\Support\Collection
     */
    public function getVisibles()
    {
        return $this->visibles;
    }

    /**
     * Возвращает интервал обновления данных
     *
     * @return int
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * Получает валюты, которые необходимо загружать
     *
     * @return Illuminate\Support\Collection
     */
    private function loads()
    {
        $loads = collect(json_decode(request()->loads));

        if ($loads->isNotEmpty())
        {
            Log::info("Получены данные о валютах, которые необходимо загружать, от клиента", [ "loads" => $loads ]);
        }

        return $loads;
    }

    /**
     * Получает интервал обновления данных
     *
     * @return int
     */
    private function interval()
    {
        $interval = request()->get("interval");

        if ($interval) 
        {
            Log::info("Получен интервал обновления данных от клиента", [ "interval" => $interval ]);
            $this->setSessionInterval($interval);
        }

        return $interval ?? $this->getSessionInterval() ?? config(self::CONFIG_DEFAULT_INTERVAL);
    }
    
    /**
     * Записывает интервал обновления данных в сессию
     *
     * @param integer $interval
     * @return void
     */
    private function setSessionInterval(int $interval)
    {
        session()->put(self::NAME_SESSION_INTERVAL, $interval);
    }

    /**
     * Возвращает интервал обновления данных из сессии
     *
     * @return int
     */
    private function getSessionInterval()
    {
        return session(self::NAME_SESSION_INTERVAL);
    }

    /**
     * Получает валюты, которые необходимо отображать
     *
     * @return Illuminate\Support\Collection
     */
    private function visibles()
    {
        $visibles = collect(json_decode(request()->visibles));

        if ($visibles->isNotEmpty())
        {
            Log::info("Получены данные о валютах, которые необходимо отображать, от клиента", [ "visibles" => $visibles ]);
        }

        return $visibles;
    }
}
