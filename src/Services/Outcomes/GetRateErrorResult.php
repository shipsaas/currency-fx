<?php

namespace CurrencyFX\Services\Outcomes;

use CurrencyFX\Enums\GetRateErrorOutcome;

final class GetRateErrorResult
{
    public function __construct(
        public GetRateErrorOutcome $outcome
    ) {
    }
}