<?php

namespace App\Enums\Enums;

enum ChestPainType: string
{
    case TYPICAL_ANGINA = 'typical angina';
    case ATYPICAL_ANGINA = 'atypical angina';
    case NON_ANGINAL = 'non-anginal';
    case ASYMPTOMATIC = 'asymptomatic';
}
