<?php


namespace App\Services;


use App\Models\Currency;
use Illuminate\Http\Request;


class CurrencyService
{
    public function search(Request $request): array
    {
        $currencies = Currency::query()
            ->when(!is_null($request['value_id']), function ($query) use ($request) {
                $query->where('value_id', $request['value_id']);
            })
            ->when(!is_null($request['from']), function ($query) use ($request) {
                $query->where('date','>=', $request['from']);
            })
            ->when(!is_null($request['to']), function ($query) use ($request) {
                $query->where('date','<=', $request['to']);
            })
            ->paginate(30);

        $values = Currency::query()->distinct()->pluck('value_id');

        return [
            'currencies' => $currencies,
            'values' => $values
        ];
    }
}
