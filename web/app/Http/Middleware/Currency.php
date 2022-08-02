<?php

namespace App\Http\Middleware;

use App\Models\Currency as ModelsCurrency;
use App\Models\Load;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Mtownsend\XmlToArray\XmlToArray;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Orchestra\Parser\Xml\Document;

class Currency
{
    protected string $xml;

    protected Document $document;

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
        $this->getData();

        if ($this->needLoading())
            $this->load();

        if ($this->needUpdating())
            $this->update();

        return $next($request);
    }

    protected function load()
    {
        $date = $this->getCurrentDate();

        $load = Load::create([
            "date" => new Carbon($date), 
        ]);

        $valutes = new Collection(XmlToArray::convert($this->xml)["Valute"]);

        foreach ($valutes as $valute)
        {
            ModelsCurrency::create([
                "num_code" => $valute["NumCode"], 
                "char_code" => $valute["CharCode"], 
                "nominal" => $valute["Nominal"], 
                "name" => $valute["Name"], 
                "value" => $this->parseValue($valute["Value"]), 
                "load_id" => $load->id, 
            ]);
        }
    }

    protected function update()
    {
        $valutes = new Collection(XmlToArray::convert($this->xml)["Valute"]);

        foreach ($valutes as $valute)
        {
            $currency = $this->load->currencies()->whereNumCode($valute["NumCode"])->first();

            if ($currency)
            {
                $currency->value = $this->parseValue($valute["Value"]);
                $currency->updated_at = now();
                $currency->save();
            }
        }
    }

    protected function getData() : void
    {
        $this->xml = file_get_contents(config("currency.source"));
        $this->document = XmlParser::load(config("currency.source"));
        
    }

    protected function needLoading() : bool
    {
        $load = Load::latest("date")->first();

        if (!$load) return true;

        $lastDate = new Carbon($load->date);

        $currentDate = new Carbon($this->getCurrentDate());

        if ($lastDate->diffInDays($currentDate, false) !== 0) return true;

        return false;
    }

    protected function needUpdating()
    {
        $load = Load::latest("date")->first();

        $updated = new Carbon($load->currencies()->first()->updated_at);

        $interval = $updated->diffInSeconds(now(), false);

        if ($interval > config("currency.default_interval"))
            return true;

        return false;
    }

    protected function getCurrentDate()
    {
        return $this->document->parse([ [ "uses" => "::Date" ] ])[0];
    }

    protected function parseValue(string $value)
    {
        return doubleval(str($value)->replace(",", ".")->toString());
    }
}
