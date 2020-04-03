<?php

namespace App\Model;

use App\Enums\PostStatus;
use App\Traits\PageScopes;
use BenSampo\Enum\Traits\CastsEnums;
use Spatie\Tags\HasTags;

/**
 * App\Model\Post
 *
 * @property int $id
 * @property int $author_id
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property string $content
 * @property \App\Enums\PostStatus|null $status
 * @property \Illuminate\Support\Carbon|null $start_at
 * @property \Illuminate\Support\Carbon|null $expired_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Model\User $author
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post published()
 * @property \Illuminate\Database\Eloquent\Collection|\App\Model\Tag[] $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post withAllTags($tags, $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post withAnyTags($tags, $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post withinSchedule()
 * @property string|null $featured_img
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereFeaturedImg($value)
 * @property-read int|null $audits_count
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post expired()
 */
class Post extends BaseModel
{
    use HasTags, PageScopes, CastsEnums;

    public $enumCasts = [
        'status' => PostStatus::class,
    ];

    public function __construct(array $attributes = [])
    {
        $this->dates[] = 'start_at';
        $this->dates[] = 'expired_at';

        parent::__construct($attributes);
    }

    public static function getTagClassName()
    {
        return Tag::class;
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
