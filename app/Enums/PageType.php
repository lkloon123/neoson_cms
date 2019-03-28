<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PageType extends Enum
{
    const Homepage = 0;
    const Error404 = 1;
    const Error500 = 2;
}
