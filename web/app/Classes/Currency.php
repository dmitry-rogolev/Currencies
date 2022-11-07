<?php

namespace App\Classes;

use App\Models\Currency as ModelCurrency;
use App\Models\Load;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

/**
 * Предоставляет функционал для получения, сохранения и настройки данных валют
 */
class Currency
{
    /**
     * Данные о валютах в виде xml
     *
     * @var SimpleXMLElement
     */
    private SimpleXMLElement $xml;

    /**
     * Предоставляет функционал получения данных от клиента
     *
     * @var \App\Classes\CurrencyRequest
     */
    private CurrencyRequest $request;

    /**
     * Валюты, которые необходимо загружать
     *
     * @var \Illuminate\Support\Collection
     */
    private Collection $loads;

    /**
     * Валюты, которые необходимо загружать
     *
     * @var \Illuminate\Support\Collection
     */
    private Collection $visibles;

    /**
     * Интервал обновления данных
     *
     * @var integer
     */
    private int $interval;

    /**
     * Оригинальные данные о валютах
     *
     * @var \Illuminate\Support\Collection
     */
    private Collection $originals;

    /**
     * Данные о валютах
     *
     * @var \Illuminate\Support\Collection
     */
    private Collection $currencies;

    /**
     * Предыдущие данные о валютах
     *
     * @var \Illuminate\Support\Collection
     */
    private Collection $previous;

    /**
     * Префикс для кеша
     */
    private const PREFIX_FOR_NAME_OF_CACHE = "currencies_";

    /**
     * Название кеша для оригинальных валютах
     */
    private const NAME_CACHE_ORIGINAL_CURRENCIES = self::PREFIX_FOR_NAME_OF_CACHE . "original_currencies";

    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->xml = HttpCurrencyServiceProvider::boot()->getXml();
        $this->request = new CurrencyRequest();
        $this->loads = $this->request->getLoads();
        $this->visibles = $this->request->getVisibles();
        $this->interval = $this->request->getInterval();
        $this->originals = $this->getOrCreateOriginalCurrencies();
        $this->previous = $this->previous();
        $this->currencies = $this->currencies();
        $this->allCurrencies = $this->allCurrencies();
    }

    /**
     * Производит настройку загрузки, обновления и отображения валют
     *
     * @return App\Classes\Currency
     */
    public static function settings()
    {
        $curry = new self;
        $curry->load();
        $curry->update();
        $curry->visibility();

        return $curry;
    }

    /**
     * Возвращает оригинальные данные о валютах
     *
     * @return \Illuminate\Support\Collection
     */
    public function getOriginals()
    {
        return $this->originals;
    }

    /**
     * Возвращает данные о валютах
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCurrencies()
    {
        return $this->parseCurrencies($this->currencies);
    }

    /**
     * Возвращает все данные о валютах
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllCurrencies()
    {
        return $this->allCurrencies;
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
     * Производит настройку загрузки данных о валютах
     * и возвращает настроенные данные
     *
     * @return \Illuminate\Support\Collection
     */
    public function load()
    {
        if ($this->needLoad())
        {
            $currencies = $this->createCurrencies();
            $this->currencies = $currencies;
            $this->allCurrencies = $this->allCurrencies();
            Log::info("Проведена загрузка данных");

            return $currencies;
        }

        return collect();
    }

    /**
     * Производит настройку обновления данных
     *
     * @return \Illuminate\Support\Collection
     */
    public function update()
    {
        if ($this->needUpdate())
        {
            $currencies = $this->updateCurrencies();
            $this->currencies = $currencies;
            Log::info("Проведено обновление данных");

            return $currencies;
        }

        return collect();
    }

    /**
     * Производит настройку видимости данных о валютах
     *
     * @return \Illuminate\Support\Collection
     */
    public function visibility()
    {
        if ($this->needChangeVisibility())
        {
            $currencies = $this->changeVisibility();
            $this->currencies = $currencies;
            Log::info("Проведено изменение видимости данных");

            return $currencies;
        }
        return collect();
    }

    /**
     * Возвращает или создает оригинальные данные о валютах
     *
     * @return \Illuminate\Support\Collection
     */
    private function getOrCreateOriginalCurrencies()
    {
        return $this->originalCurrencies() ?? $this->createOriginalCurrencies();
    }

    /**
     * Получает из кеша оригинальные валюты
     *
     * @return \Illuminate\Support\Collection
     */
    private function originalCurrencies()
    {
        return cache(self::NAME_CACHE_ORIGINAL_CURRENCIES);
    }

    /**
     * Создает и сохраняет в кеше оригинальные данные о валютах
     *
     * @return \Illuminate\Support\Collection
     */
    private function createOriginalCurrencies()
    {
        $originals = collect();

        foreach ($this->xml as $valute)
        {
            $originals->push(ModelCurrency::factory()->make([
                "num_code" => (int) $valute->NumCode, 
                "char_code" => (string) $valute->CharCode, 
                "nominal" => (string) $valute->Nominal, 
                "name" => (string) $valute->Name, 
                "value" => $this->parseValue($valute->Value), 
            ]));
        }

        $this->cacheOriginals($originals);

        return $originals;
    }

    /**
     * Преобразует строку к типу float
     *
     * @param string $value
     * @return float
     */
    private function parseValue(string $value)
    {
        return doubleval(str($value)->replace(",", ".")->toString());
    }

    /**
     * Сохраняет оригинальные данные о валютах в кеше
     *
     * @param \Illuminate\Support\Collection $originals
     * @return void
     */
    private function cacheOriginals(Collection $originals)
    {
        cache()->put(self::NAME_CACHE_ORIGINAL_CURRENCIES, $originals);
    }

    /**
     * Получает предыдущие данные о валютах
     *
     * @return \Illuminate\Support\Collection
     */
    private function previous()
    {
        $previous = Load::latest("id")->limit(2)->get()->skip(1)->first()?->currencies()->visible()->get();

        if ($previous) return $previous;

        return collect();
    }

    /**
     * Получает данные о валютах
     *
     * @return \Illuminate\Support\Collection
     */
    private function currencies()
    {
        $load = $this->lastLoad();

        if ($load) return $load->currencies()->visible()->get();

        return collect();
    }

    /**
     * Получает последнюю загрузку
     *
     * @return \App\Models\Load
     */
    private function lastLoad()
    {
        return Load::latest("id")->first();
    }

    /**
     * Преобразует данные о валютах
     *
     * @param \Illuminate\Support\Collection $currencies
     * @return \Illuminate\Support\Collection
     */
    private function parseCurrencies(Collection $currencies)
    {
        $previous = $this->previous;

        $currencies->map(function($item) use ($previous)
        {
            $preview = $this->getCurrency($previous, (int) $item->num_code);

            if ($preview)
            {
                if ($preview->value < $item->value)
                {
                    $item->changes = 1;
                }
                else if ($preview->value > $item->value)
                {
                    $item->changes = -1;
                }
                else 
                {
                    $item->changes = 0;
                }
            }
            else 
            {
                $item->changes = 0;
            }
        });

        return $currencies;
    }

    /**
     * Получает экземпляр валюты по его коду
     *
     * @param \Illuminate\Support\Collection $currencies
     * @param integer $num_code
     * @return \App\Models\Currency
     */
    private function getCurrency(Collection $currencies, int $num_code)
    {
        if ($currencies->isEmpty()) return null;

        return $currencies->first(function($value) use ($num_code)
        {
            return $value->num_code == $num_code;
        });
    }

    /**
     * Получает все данные о валютах
     *
     * @return \Illuminate\Support\Collection
     */
    private function allCurrencies()
    {
        $load = $this->lastLoad();

        if ($load) return $load->currencies;

        return collect();
    }

    /**
     * Проверяет необходимость загрузки данных
     *
     * @return bool
     */
    private function needLoad()
    {
        return $this->loads->isNotEmpty() || $this->isChanged(); 
    }
    
    /**
     * Проверяет изменение даты в данных валют
     *
     * @return boolean
     */
    private function isChanged()
    {
        $lastLoadDate = $this->lastDate();
        $currentDate = $this->currentDate();

        if ($lastLoadDate && $lastLoadDate == $currentDate) return false;

        return true;
    }

    /**
     * Получает дату последней загрузки
     *
     * @return \Illuminate\Support\Carbon|null
     */
    private function lastDate()
    {
        $lastLoad = $this->lastLoad();

        if ($lastLoad) return new Carbon($lastLoad->date);

        return null;
    }

    /**
     * Получает текущую дату в данных валют
     *
     * @return \Illuminate\Support\Carbon
     */
    private function currentDate()
    {
        return new Carbon((string) $this->xml["Date"]);
    }

    /**
     * Сохраняет данные о валютах в базе данных
     *
     * @return \Illuminate\Support\Collection
     */
    private function createCurrencies()
    {
        $load = $this->createLoad();

        $currencies = collect();

        foreach ($this->xml as $valute)
        {
            if ($this->needSave((int) $valute->NumCode))
            {
                $currencies->push(ModelCurrency::create([
                    "num_code" => (int) $valute->NumCode, 
                    "char_code" => (string) $valute->CharCode, 
                    "nominal" => (int) $valute->Nominal, 
                    "name" => (string) $valute->Name, 
                    "value" => $this->parseValue((string) $valute->Value), 
                    "visibility" => 1, 
                    "load_id" => $load->id, 
                ]));
            }
        }

        return $currencies;
    }

    /**
     * Создает загрузку в базе данных
     *
     * @return \App\Models\Load
     */
    private function createLoad()
    {
        return Load::create([
            "date" => $this->currentDate(), 
        ]);
    }

    /**
     * Проверяет необходимость сохранения экземпляра валюты в базе данных по его коду
     *
     * @param integer $num_code
     * @return bool
     */
    private function needSave(int $num_code)
    {
        if ($this->loads->isNotEmpty())
        {
            return $this->loads->contains($num_code);
        }

        return true;
    }

    /**
     * Проверяет необходимость обновления данных
     *
     * @return bool
     */
    private function needUpdate()
    {
        return $this->currencies->isNotEmpty() && $this->interval < $this->calculateIntervalUpdated();
    }

    /**
     * Вычисляет интервал времени с последнего обновления
     *
     * @return int
     */
    private function calculateIntervalUpdated()
    {
        return $this->updated()->diffInSeconds(now());
    }

    /**
     * Получает время последнего обвновления
     *
     * @return \Illuminate\Support\Carbon
     */
    private function updated()
    {
        return new Carbon($this->currencies->first()->updated_at);
    }

    /**
     * Обновляет данные о валютах
     *
     * @return \Illuminate\Support\Collection
     */
    private function updateCurrencies()
    {
        $updatedCurrencies = collect();

        foreach ($this->xml as $valute)
        {
            $currency = $this->getCurrency($this->currencies, (int) $valute->NumCode);

            if ($currency)
            {
                $currency->value = $this->parseValue($valute->Value);
                $currency->updated_at = now();
                $currency->save();
                $currency->refresh();
                $updatedCurrencies->push($currency);
            }
        }

        return $updatedCurrencies;
    }

    /**
     * Проверяет необходимость изменения видимости
     *
     * @return bool
     */
    private function needChangeVisibility()
    {
        return $this->visibles->isNotEmpty();
    }

    /**
     * Изменяет видимость данных о валютах
     *
     * @return \Illuminate\Support\Collection
     */
    private function changeVisibility()
    {
        $visibles = collect();

        foreach ($this->allCurrencies as $currency)
        {
            if ($this->visibles->contains($currency->num_code))
            {
                $currency->visibility = true;
                $currency->save();
                $visibles->push($currency);
            }
            else 
            {
                $currency->visibility = false;
                $currency->save();
            }
        }

        return $visibles;
    }
}
