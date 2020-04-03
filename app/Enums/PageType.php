<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static PageType Homepage()
 * @method static PageType Page()
 * @method static PageType Post()
 * @method static PageType Tag()
 * @method static PageType Error404()
 * @method static PageType Error500()
 */
final class PageType extends Enum
{
    const Homepage = 0;
    const Page = 1;
    const Post = 2;
    const Tag = 3;
    const Error404 = 4;
    const Error500 = 5;
}
