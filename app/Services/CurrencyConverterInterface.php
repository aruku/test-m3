<?php

namespace App\Services;

interface CurrencyConverterInterface
{
    public function __invoke(float $amount, string $from, string $to): array;
}
