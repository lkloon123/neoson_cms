<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PageType extends Enum
{
    const Homepage = 0;
    const Page = 1;
    const Post = 2;
    const Error404 = 3;
    const Error500 = 4;
}
