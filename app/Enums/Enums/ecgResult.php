<?php

namespace App\Enums\Enums;

enum ecgResult: string
{
    case NORMAL = 'normal';
    case STT_ABNORMALITY = 'stt abnormality';
    case LV_HYPERTROPHY = 'lv hypertrophy';
}
