<?php

namespace App\Http\Controllers;

use App\Models\Load;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WelcomeController extends Controller
{
    public function show()
    {
        $previous = Load::latest("date")->limit(2)->get()->skip(1)->first()?->currencies;

        $currencies = Load::latest("date")->first()->currencies;

        return view("welcome", [
            "previous" => $previous, 
            "currencies" => $currencies, 

            "settings" => [
                "target" => Str::random(60), 
                "labelledby" => Str::random(60),  
            ]
        ]);
    }
}
