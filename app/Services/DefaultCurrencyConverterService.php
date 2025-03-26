<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class DefaultCurrencyConverterService implements CurrencyConverterInterface
{
    public function __invoke(float $amount, string $from, string $to): array
    {
        $url = "https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/$from.min.json";

        try {
            $response = Http::retry(3, 100)->get($url);
        } catch (ConnectionException) {
            $url = "https://latest.currency-api.pages.dev/v1/currencies/$from.min.json";

            $response = Http::retry(3, 100)->get($url);
        } catch (RequestException) {
            throw new NotFoundHttpException('The first currency doesn\'t exist');
        }

        if (!isset($response[$from][$to])) {
            throw new NotFoundHttpException('The second currency doesn\'t exist');
        }

        $rate = $response[$from][$to];

        return [
            $from => $amount,
            $to => $amount * $rate
        ];
    }
}
