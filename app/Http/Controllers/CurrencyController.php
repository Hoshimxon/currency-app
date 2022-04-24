<?php

namespace App\Http\Controllers;


use App\Http\Requests\CurrencyFilter;
use App\Http\Requests\LoadCurrencies;
use App\Services\CbrService;
use App\Services\CurrencyService;

class CurrencyController extends Controller
{
    public function index(CurrencyFilter $request, CurrencyService $currencyService)
    {
        $items = $currencyService->search($request);

        return view('index', compact('items'));
    }

    public function loadCurrencies(LoadCurrencies $request, CbrService $cbr, CurrencyService $currencyService)
    {
        try {
            $cbr->getDynamic($request['days']);
            $items = $currencyService->search($request);
            return view('index', compact('items'));
        }catch (\Exception $exception){
            return redirect()->route('index');
        }
    }
}
