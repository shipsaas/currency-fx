<?php

namespace CurrencyFX\Enums;

enum GetRateErrorOutcome
{
    case UNEXPECTED_ERROR;
    case AUTHENTICATION_FAILED;
}