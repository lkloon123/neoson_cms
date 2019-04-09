<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PermissionType extends Enum
{
    const Allow = 0;
    const Disallow = 1;
    const OnlyOwn = 2;
}
