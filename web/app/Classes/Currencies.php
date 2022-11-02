<?php

namespace App\Classes;

use App\Models\Currency;
use App\Models\Load;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use SimpleXMLElement;

class Currencies
{
    private SimpleXMLElement $xml;

    private Collection $originals;

    private Collection $loads;

    private Collection $currencies;

    private Collection $visibles;

    private Collection $previous;

    private int $interval;

    private const PREFIX_FOR_NAME_OF_CACHE = "currencies_";

    private const NAME_CACHE_ORIGINAL_CURRENCIES = self::PREFIX_FOR_NAME_OF_CACHE . "original_currencies";

    private const NAME_SESSION_INTERVAL = self::PREFIX_FOR_NAME_OF_CACHE . "interval_update_currencies";

    public function __construct()
    {
        $this->xml = $this->getXml();
        $this->originals = $this->getOrCreateOriginalCurrencies();
        $this->loads = $this->getRequestLoads();
        $this->previous = $this->getPrevious();
        $this->currencies = $this->getCurrencies();
        $this->interval = $this->getInterval();
        $this->visibles = $this->getRequestVisibles();
        $this->allCurrencies = $this->getAllCurrencies();
    }

    public static function settings()
    {
        $curry = self::new();
        $curry->load();
        $curry->update();
        $curry->visibility();

        return $curry;
    }

    public function originals()
    {
        return $this->originals;
    }

    public function currencies()
    {
        return $this->parseCurrencies($this->currencies);
    }

    public function allCurrencies()
    {
        return $this->allCurrencies;
    }

    public function interval()
    {
        return $this->interval;
    }

    public function load()
    {
        if ($this->needLoad())
        {
            $currencies = $this->createCurrencies();
            $this->currencies = $currencies;
            $this->allCurrencies = $this->getAllCurrencies();

            return $currencies;
        }

        return collect();
    }

    public function update()
    {
        if ($this->needUpdate())
        {
            $currencies = $this->updateCurrencies();
            $this->currencies = $currencies;
            return $currencies;
        }

        return collect();
    }

    public function visibility()
    {
        if ($this->needChangeVisibility())
        {
            $currencies = $this->changeVisibility();
            $this->currencies = $currencies;
            return $currencies;
        }
        return collect();
    }
    
    private function isChanged()
    {
        $lastLoadDate = $this->getLastDate();
        $currentDate = $this->getCurrentDate();

        if ($lastLoadDate && $lastLoadDate == $currentDate) return false;

        return true;
    }

    /**
     * Загружает данные с сервера
     *
     * @return SimpleXMLElement
     */
    private function getXml()
    {
        $try = 0;

        while (true)
        {
            try {
                $xml = file_get_contents(config("currency.source"));
                break;
            }
            catch (Exception $e) {
                if ($try > 5) throw $e;
                $try++;
                continue;
            }
        }

        return new SimpleXMLElement($xml);
    }

    private function getLastLoad()
    {
        return Load::latest("id")->first();
    }

    private function getLastDate()
    {
        $lastDate = $this->getLastLoad();

        if ($lastDate) return new Carbon($lastDate->date);

        return null;
    }

    private function getCurrentDate()
    {
        return new Carbon((string) $this->xml["Date"]);
    }

    private function createOriginalCurrencies()
    {
        $originals = collect();

        foreach ($this->xml as $valute)
        {
            $originals->push(Currency::factory()->make([
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

    private function parseValue(string $value)
    {
        return doubleval(str($value)->replace(",", ".")->toString());
    }

    private function cacheOriginals(Collection $originals)
    {
        cache()->put(self::NAME_CACHE_ORIGINAL_CURRENCIES, $originals);
    }

    private function getOriginalCurrencies()
    {
        return cache(self::NAME_CACHE_ORIGINAL_CURRENCIES);
    }

    private function getOrCreateOriginalCurrencies()
    {
        return $this->getOriginalCurrencies() ?? $this->createOriginalCurrencies();
    }

    private function createCurrencies()
    {
        $load = $this->createLoad();

        $currencies = collect();

        foreach ($this->xml as $valute)
        {
            if ($this->needSave($valute->NumCode[0]))
            {
                $currencies->push(Currency::create([
                    "num_code" => $valute->NumCode[0], 
                    "char_code" => $valute->CharCode[0], 
                    "nominal" => $valute->Nominal[0], 
                    "name" => $valute->Name[0], 
                    "value" => $this->parseValue($valute->Value[0]), 
                    "visibility" => true, 
                    "load_id" => $load->id, 
                ]));
            }
        }

        return $currencies;
    }

    private function createLoad()
    {
        return Load::create([
            "date" => $this->getCurrentDate(), 
        ]);
    }

    private function getRequestLoads()
    {
        if (request()->has("loads"))
        {
            return collect(json_decode(request()->loads));
        }

        return collect();
    }

    private function needSave($num_code)
    {
        if ($this->loads->isNotEmpty())
        {
            return $this->loads->contains($num_code);
        }

        return true;
    }

    private function needLoad()
    {
        return $this->loads->isNotEmpty() || $this->isChanged(); 
    }

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

    private function getCurrencies()
    {
        $load = $this->getLastLoad();

        if ($load) return $load->currencies()->visible()->get();

        return collect();
    }

    private function getCurrency(Collection $currencies, int $num_code)
    {
        if ($currencies->isEmpty()) return null;

        return $currencies->first(function($value) use ($num_code)
        {
            return $value->num_code == $num_code;
        });
    }

    private function getUpdated()
    {
        return new Carbon($this->currencies->first()->updated_at);
    }

    private function calculateIntervalUpdated()
    {
        return $this->getUpdated()->diffInSeconds(now());
    }

    private function getRequestInterval()
    {
        $interval = request()->get("interval");

        if ($interval) $this->setSessionInterval($interval);

        return $interval;
    }

    private function getSessionInterval()
    {
        return session(self::NAME_SESSION_INTERVAL);
    }

    private function setSessionInterval(int $interval)
    {
        session()->put(self::NAME_SESSION_INTERVAL, $interval);
    }

    private function getInterval()
    {
        return $this->getRequestInterval() ?? $this->getSessionInterval() ?? config("currency.default_interval");
    }

    private function needUpdate()
    {
        return $this->currencies->isNotEmpty() && $this->interval > $this->calculateIntervalUpdated();
    }

    private function getRequestVisibles()
    {
        return collect(json_decode(request()->visibles));
    }

    private function getAllCurrencies()
    {
        return $this->getLastLoad()->currencies;
    }

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

    private function needChangeVisibility()
    {
        return $this->visibles->isNotEmpty();
    }

    private function getPrevious()
    {
        $valutes = Load::latest("id")->limit(2)->get()->skip(1)->first()?->currencies()->visible()->get();

        if ($valutes) return $valutes;

        return collect();
    }

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

    public static function new()
    {
        return new self;
    }
}
