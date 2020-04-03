<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static AbstractContent Publish()
 * @method static AbstractContent Expired()
 * @method static AbstractContent PendingReview()
 * @method static AbstractContent Draft()
 */
abstract class AbstractContent extends Enum
{
    const Publish = 0;
    const Expired = 1;
    const PendingReview = 2;
    const Draft = 3;
}
