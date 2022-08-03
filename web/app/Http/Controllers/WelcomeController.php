<?php

namespace App\Http\Controllers;

use App\Models\Load;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WelcomeController extends Controller
{
    public function show()
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

        $currencies = Load::latest("id")->first()->currencies()->visible()->get();

        return view("welcome", [
            "previous" => $previous, 
            "currencies" => $currencies, 
            "originals" => cache("originals"), 

            "settings" => [
                "target" => Str::random(60), 
                "labelledby" => Str::random(60),  
            ]
        ]);
    }

    public function settings(Request $request)
    {
        $request->validate([
            "loads" => [ "array" ], 
            "loads.*" => [ "integer" ], 
            "show" => [ "array" ], 
            "show.*" => [ "integer" ], 
            "interval" => [  ], 
        ]);

        $this->loads();

        $this->visible();

        $this->interval();

        return back();
    }

    protected function loads()
    {
        if (request()->has("loads"))
        {
            cache()->put("loads", request()->loads, config("cache.keep"));
            cache()->put("load", true, config("cache.keep"));
        }
    }

    protected function visible()
    {
        if (request()->has("visible"))
        {
           $load = Load::latest("date")->first();

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

    protected function interval()
    {
        if (request()->has("interval"))
        {
            cache()->put("interval", abs(intval(request()->interval)));
        }
    }
}
