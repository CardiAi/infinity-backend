<?php

namespace App\Enums\Enums;

enum slopeResult: string
{
    case FLAT = 'flat';
    case DOWNSLOPING = 'downsloping';
    case UPSLOPING = 'upsloping';
}
