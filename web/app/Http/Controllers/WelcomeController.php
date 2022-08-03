<?php

namespace App\Http\Controllers;

use App\Models\Load;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;

class WelcomeController extends Controller
{
    /**
     * Рендерит и возвращает шаблон welcome
     *
     * @return View|Factory
     */
    public function show() : View | Factory
    {
        $previous = $this->previous();

        $currencies = Load::latest("id")->first()->currencies()->visible()->get();

        $visibles = Load::latest("id")->first()->currencies;

        return view("welcome", [
            "previous" => $previous, 
            "currencies" => $currencies, 
            "originals" => cache("originals"), 
            "visibles" => $visibles, 

            "settings" => [
                "target" => id(), 
                "labelledby" => id(),  
            ]
        ]);
    }

    /**
     * Применяет переданные в Request настройки
     *
     * @return RedirectResponse
     */
    public function settings() : RedirectResponse
    {
        $this->loads();

        $this->visible();

        $this->interval();

        return back();
    }

    /**
     * Применяет настройку загрузки данных с xml
     *
     * @return void
     */
    private function loads() : void
    {
        if (request()->has("loads"))
        {
            cache()->put("loads", request()->loads, config("cache.keep"));
            cache()->put("load", true, config("cache.keep"));
        }
    }

    /**
     * Применяет настройку отображения валют
     *
     * @return void
     */
    private function visible() : void
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

    /**
     * Применяет настройку интервала обновления данных
     *
     * @return void
     */
    private function interval() : void
    {
        if (request()->has("interval"))
        {
            cache()->put("interval", abs(intval(request()->interval)));
        }
    }

    /**
     * Возвращает предыдущую загрузку данных от последней
     *
     * @return Collection
     */
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
