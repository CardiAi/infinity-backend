<?php

namespace App\Enums\Enums;

enum thalType: string
{
    case NORMAL = 'normal';
    case FIXED_DEFECT = 'fixed defect';
    case REVERSIBLE_DEFECT = 'reversable defect';
}
