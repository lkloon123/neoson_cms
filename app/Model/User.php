<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Laratrust\Traits\LaratrustUserTrait;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereIs($role)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereIsAll($role)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereIsNot($role)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Page[] $pages
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereDeletedAt($value)
 * @property \Illuminate\Support\Carbon|null $last_login_at
 * @property string|null $last_login_ip
 * @property \Illuminate\Support\Carbon|null $last_logout_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereLastLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereLastLogoutAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Menu[] $menus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Page[] $posts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Form[] $forms
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User orWherePermissionIs($permission = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User orWhereRoleIs($role = '', $team = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePermissionIs($permission = '', $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereRoleIs($role = '', $team = null, $boolean = 'and')
 */
class User extends BaseModel implements MustVerifyEmail, AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Notifiable, Authenticatable, CanResetPassword, MustVerifyEmailTrait, LaratrustUserTrait;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'pivot'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        $this->dates[] = 'last_login_at';
        $this->dates[] = 'last_logout_at';

        $this->auditExclude[] = 'last_login_at';
        $this->auditExclude[] = 'last_login_ip';
        $this->auditExclude[] = 'last_logout_at';

        parent::__construct($attributes);
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'author_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function forms()
    {
        return $this->hasMany(Form::class);
    }
}
