<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PageStatus extends Enum
{
    const Publish = 0;
    const Expired = 1;
    const PendingReview = 2;
    const Draft = 3;
}
