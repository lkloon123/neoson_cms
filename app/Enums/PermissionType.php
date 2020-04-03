<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static PermissionType Allow()
 * @method static PermissionType Disallow()
 * @method static PermissionType OnlyOwn()
 */
final class PermissionType extends Enum
{
    const Allow = 0;
    const Disallow = 1;
    const OnlyOwn = 2;
}
