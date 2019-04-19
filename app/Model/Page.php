<?php

namespace App\Model;

use App\Traits\PageScopes;

/**
 * App\Model\Page
 *
 * @property int $id
 * @property int $author_id
 * @property string $title
 * @property string $slug
 * @property int|null $parent_id
 * @property string|null $description
 * @property string $content
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $start_at
 * @property \Illuminate\Support\Carbon|null $expired_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Model\User $author
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page withinSchedule()
 * @property string|null $featured_img
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Page whereFeaturedImg($value)
 */
class Page extends BaseModel
{
    use PageScopes;

    public function __construct(array $attributes = [])
    {
        $this->dates[] = 'start_at';
        $this->dates[] = 'expired_at';

        parent::__construct($attributes);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
