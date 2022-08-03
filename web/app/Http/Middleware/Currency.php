<?php

namespace App\Http\Middleware;

use App\Models\Currency as ModelsCurrency;
use App\Models\Load;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use SimpleXMLElement;

class Currency
{
    protected SimpleXMLElement $xml;

    protected ?Load $load;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->needLoading())
            $this->load();

        else if ($this->needUpdating())
            $this->update();

        return $next($request);
    }

    protected function load()
    {
        $this->getData();

        $date = $this->getCurrentDate();

        $load = Load::create([
            "date" => new Carbon($date), 
        ]);

        $loads = collect(cache("loads"));

        $originals = collect();

        foreach ($this->xml as $valute)
        {
            $originals->push(ModelsCurrency::factory()->make([
                "num_code" => (int) $valute->NumCode, 
                "char_code" => (string) $valute->CharCode, 
                "nominal" => (string) $valute->Nominal, 
                "name" => (string) $valute->Name, 
                "value" => $this->parseValue($valute->Value), 
                "load_id" => $load->id, 
            ]));

            if ($loads->isNotEmpty() && !$loads->contains($valute->NumCode))
                continue;

            ModelsCurrency::create([
                "num_code" => $valute->NumCode, 
                "char_code" => $valute->CharCode, 
                "nominal" => $valute->Nominal, 
                "name" => $valute->Name, 
                "value" => $this->parseValue($valute->Value), 
                "visibility" => true, 
                "load_id" => $load->id, 
            ]);
        }

        cache()->put("originals", $originals);
    }

    protected function update()
    {
        $this->getData();

        $load = $this->getLastLoad();

        foreach ($this->xml as $valute)
        {
            $currency = $load->currencies()->whereNumCode($valute->NumCode)->first();

            if ($currency)
            {
                $currency->value = $this->parseValue($valute->Value);
                $currency->updated_at = now();
                $currency->save();
            }
        }
    }

    protected function getData() : void
    {
        while (true)
        {
            try {
                $xml = file_get_contents(config("currency.source"));
                break;
            }
            catch (Exception $e) {
                continue;
            }
        }

        $this->xml = new SimpleXMLElement($xml);
    }

    protected function needLoading() : bool
    {
        if (cache()->pull("load")) return true;

        $load = $this->getLastLoad();

        if (!$load) return true;

        $lastDate = new Carbon($load->date);

        if ($lastDate->diffInDays(today()) !== 0) return true;

        return false;
    }

    protected function needUpdating()
    {
        $load = $this->getLastLoad();

        $updated = new Carbon($load->currencies()->first()->updated_at);

        $interval = $updated->diffInSeconds(now());

        if (cache()->has("interval") && $interval > cache("interval") || $interval > config("currency.default_interval"))
            return true;

        return false;
    }

    private function getCurrentDate()
    {
        return (string) $this->xml["Date"];
    }

    private function parseValue(string $value)
    {
        return doubleval(str($value)->replace(",", ".")->toString());
    }

    private function getLastLoad() : ?Load
    {
        return Load::latest("id")->first();
    }
}
