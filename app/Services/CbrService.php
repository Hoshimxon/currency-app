<?php


namespace App\Services;


use App\Models\Currency;
use Illuminate\Support\Carbon;

class CbrService
{
    public $daily_url = 'https://www.cbr.ru/scripts/XML_daily.asp';
    public $dynamic_url = 'https://www.cbr.ru/scripts/XML_dynamic.asp';

    public function getXmlData($xml_url)
    {
        $xml_data_parsing = file_get_contents($xml_url);
        $xml_object = simplexml_load_string($xml_data_parsing);
        $json = json_encode($xml_object);
        return json_decode($json, true);
    }


    public function getDynamic($days)
    {
        $from = Carbon::now()->subDays($days)->format('d/m/Y');
        $to = Carbon::today()->format('d/m/Y');

        $xml_url = $this->dynamic_url . '?date_req1=' . $from . '&date_req2=' . $to;

        $daily_currencies = $this->getXmlData($this->daily_url);

        $daily_currencies = $daily_currencies['Valute'];

        $currencies = [];

        foreach ($daily_currencies as $daily_currency) {

            $dynamic_currencies = $this->getXmlData($xml_url . '&VAL_NM_RQ=' . $daily_currency['@attributes']['ID']);

            $dynamic_currencies = $dynamic_currencies['Record'];

            foreach ($dynamic_currencies as $dynamic_currency) {
                array_push($currencies, [
                    'value_id' => $daily_currency['@attributes']['ID'],
                    'num_code' => $daily_currency['NumCode'],
                    'char_code' => $daily_currency['CharCode'],
                    'name' => $daily_currency['Name'],
                    'value' => floatval(str_replace(',', '.', $dynamic_currency['Value'])),
                    'date' => Carbon::createFromFormat('d/m/Y', str_replace('.', '/', $dynamic_currency['@attributes']['Date']))->format('Y-m-d')
                ]);
            }

        }

        Currency::query()->upsert(
            $currencies,
            ['value_id', 'date'],
            ['num_code', 'char_code', 'name', 'value']
        );

    }
}
