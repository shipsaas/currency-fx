<?php

namespace CurrencyFX\Enums;

enum GetRateErrorOutcome
{
    case UNEXPECTED_ERROR;
    case RETRIEVE_RATE_FAILED;
    case AUTHENTICATION_FAILED;
}