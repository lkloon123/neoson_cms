<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 4/11/2019
 * Time: 10:02 AM.
 */

namespace App\Traits;

use App\Enums\AbstractContent;
use Illuminate\Database\Eloquent\Builder;

trait PageScopes
{
    public function scopePublished(Builder $query)
    {
        return $query->where('status', AbstractContent::Publish);
    }

    public function scopeWithinSchedule(Builder $query)
    {
        $now = now();
        return $query->whereDate('start_at', '<=', $now)
            ->whereDate('expired_at', '>=', $now);
    }

    public function scopeExpired(Builder $query)
    {
        return $query->whereDate('expired_at', '<=', now());
    }
}
