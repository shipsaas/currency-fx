<?php

namespace CurrencyFX\Services\Outcomes;

final class GetRateOkResult
{
    public function __construct(
        public float $rate
    ) {
    }
}