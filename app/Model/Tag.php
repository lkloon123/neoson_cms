<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 4/10/2019
 * Time: 10:01 AM.
 */

namespace App\Model;

/**
 * App\Model\Tag
 *
 * @property int $id
 * @property array $name
 * @property array $slug
 * @property string|null $type
 * @property int|null $order_column
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Tags\Tag containing($name, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Tags\Tag ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereOrderColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Tags\Tag withType($type = null)
 * @mixin \Eloquent
 */
class Tag extends \Spatie\Tags\Tag
{
    public static function getAllWithCount()
    {
        $relation = \DB::table('taggables')->get();
        return self::get()->map(function ($item) use ($relation) {
            $item->count = $relation->where('tag_id', $item->id)->count();
            return $item;
        });
    }

    public static function findFromSlug(string $slug, string $type = null, string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return static::query()
            ->where("slug->{$locale}", $slug)
            ->where('type', $type);
    }

    public function setAttribute($key, $value)
    {
        if (($key === 'name' || $key === 'slug') && !\is_array($value)) {
            return $this->setTranslation($key, app()->getLocale(), $value);
        }

        return parent::setAttribute($key, $value);
    }

    protected function generateSlug(string $locale): string
    {
        if ($this->getTranslation('slug', $locale)) {
            return $this->getTranslation('slug', $locale);
        }

        $slugger = config('tags.slugger');

        $slugger = $slugger ?: '\Illuminate\Support\Str::slug';

        return call_user_func($slugger, $this->getTranslation('name', $locale));
    }
}
