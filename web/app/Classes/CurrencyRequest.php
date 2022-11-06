<?php

namespace App\Classes;

use Illuminate\Support\Collection;

/**
 * Получает данные от клиента
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
     * Интервал обновления данных
     *
     * @var integer
     */
    private ?int $interval;

    private const PREFIX_FOR_NAME_OF_CACHE = "currencies_";

    private const NAME_SESSION_INTERVAL = self::PREFIX_FOR_NAME_OF_CACHE . "interval_update_currencies";

    public function __construct()
    {
        $this->loads = $this->loads();
        $this->interval = $this->interval();
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
     * Возвращает интервал обновления данных
     *
     * @return ?int
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
        if (request()->has("loads"))
        {
            return collect(json_decode(request()->loads));
        }

        return collect();
    }

    /**
     * Получает интервал обновления данных
     *
     * @return int
     */
    private function interval()
    {
        $interval = request()->get("interval");

        if ($interval) $this->setSessionInterval($interval);

        return $interval ?? $this->getSessionInterval() ?? config("currency.default_interval");
    }

    private function setSessionInterval(int $interval)
    {
        session()->put(self::NAME_SESSION_INTERVAL, $interval);
    }

    private function getSessionInterval()
    {
        return session(self::NAME_SESSION_INTERVAL);
    }
}
