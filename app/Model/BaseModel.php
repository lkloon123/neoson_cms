<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/7/2019
 * Time: 9:33 AM.
 */

namespace App\Model;


use App\Observers\ObserverForHooks;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Model\BaseModel
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BaseModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\BaseModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BaseModel query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\BaseModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\BaseModel withoutTrashed()
 * @mixin \Eloquent
 * @property-read int|null $audits_count
 */
class BaseModel extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable, SoftCascadeTrait;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];
    protected $hidden = ['pivot'];
    protected $auditExclude = ['remember_token'];

    public function __construct(array $attributes = [])
    {
        \HookManager::dispatch('model.' . Str::snake(class_basename($this)) . '.constructing', $this);

        parent::__construct($attributes);

        \HookManager::dispatch('model.' . Str::snake(class_basename($this)) . '.constructed', $this);
    }

    protected static function booted()
    {
        self::observe(ObserverForHooks::class);
    }
}
