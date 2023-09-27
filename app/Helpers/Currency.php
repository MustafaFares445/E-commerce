<?php

namespace App\Helpers;

class Currency
{
    public function __invoke(...$params): bool|string
    {
        return static::format(...$params);
    }

    public static function format($amount , $currency = null): bool|string
    {
        $formatter = new \NumberFormatter(config('app.locale') , \NumberFormatter::CURRENCY);

        if ($currency === null){
            $currency = config('app.currency' , 'USD');
        }

        return $formatter->format($amount , $currency);
    }
}
