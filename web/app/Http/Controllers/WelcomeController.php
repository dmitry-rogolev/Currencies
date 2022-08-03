<?php

namespace App\Http\Controllers;

use App\Models\Load;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class WelcomeController extends Controller
{
    public function show()
    {
        $previous = $this->previous();

        $currencies = Load::latest("id")->first()->currencies()->visible()->get();

        return view("welcome", [
            "previous" => $previous, 
            "currencies" => $currencies, 
            "originals" => cache("originals"), 

            "settings" => [
                "target" => id(), 
                "labelledby" => id(),  
            ]
        ]);
    }

    public function settings()
    {
        $this->loads();

        $this->visible();

        $this->interval();

        return back();
    }

    private function loads()
    {
        if (request()->has("loads"))
        {
            cache()->put("loads", request()->loads, config("cache.keep"));
            cache()->put("load", true, config("cache.keep"));
        }
    }

    private function visible()
    {
        if (request()->has("visible"))
        {
           $load = Load::latest("id")->first();

           $visible = collect(request()->visible);

           foreach ($load->currencies as $currency)
           {
                if ($visible->contains($currency->num_code))
                {
                    $currency->visibility = true;
                    $currency->save();
                }
                else 
                {
                    $currency->visibility = false;
                    $currency->save();
                }
           }
        }
    }

    private function interval()
    {
        if (request()->has("interval"))
        {
            cache()->put("interval", abs(intval(request()->interval)));
        }
    }

    private function previous() : Collection
    {
        $valutes = Load::latest("id")->limit(2)->get()->skip(1)->first()?->currencies()->visible()->get();

        $previous = collect();

        if ($valutes)
        {
            foreach ($valutes as $valute)
            {
                $previous->put($valute->num_code, $valute->value);
            }
        }

        return $previous;
    }
}
