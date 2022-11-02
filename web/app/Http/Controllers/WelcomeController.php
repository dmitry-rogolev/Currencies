<?php

namespace App\Http\Controllers;

use App\Classes\Currencies;
use App\Models\Load;
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function store(Request $request)
    {
        $curry = Currencies::settings();

        return response()->json([
            "currencies" => $curry->currencies(), 
            "originals" => $curry->originals(), 
            "visibles" => $curry->allCurrencies(), 
            "interval" => $curry->interval(), 
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
        $curry = Currencies::settings();

        return response()->json([
            "currencies" => $curry->currencies(), 
            "visibles" => $curry->allCurrencies(), 
            "interval" => $curry->interval(), 
        ]);
    }
}
