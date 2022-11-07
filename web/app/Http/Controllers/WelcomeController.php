<?php

namespace App\Http\Controllers;

use App\Classes\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function store(Request $request)
    {
        $curry = Currency::settings();

        return response()->json([
            "originals" => $curry->getOriginals(), 
            "currencies" => $curry->getCurrencies(), 
            "visibles" => $curry->getAllCurrencies(), 
            "interval" => $curry->getInterval(), 
            "header" => config("view.title"), 
        ]);
    }

    /**
     * Применяет переданные в Request настройки
     *
     * @return JsonResponse
     */
    public function settings()
    {
        $curry = Currency::settings();

        return response()->json([
            "currencies" => $curry->getCurrencies(), 
            "visibles" => $curry->getAllCurrencies(), 
            "interval" => $curry->getInterval(), 
        ]);
    }
}
