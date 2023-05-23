<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// Spatie
use App\Models\Enums\Roles;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;

class User extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;
    use SoftDeletes;
    use HasUuid;
    use HasRoles;
    use HasPermissions;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'options',
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'email_verified_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'options' => AsArrayObject::class,
    ];

    /**
     * {@inheritdoc}
     */
    protected $with = [
        'roles',
    ];


    public function isReader(): bool
    {
        return $this->hasRole(Roles::READER->value);
    }

    public function isPublisher(): bool
    {
        return $this->hasRole(Roles::PUBLISHER->value);
    }

    public function isEditor(): bool
    {
        return $this->hasRole(Roles::EDITOR->value);
    }

    public function isModerator(): bool
    {
        return $this->hasRole(Roles::MODERATOR->value);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(Roles::ADMIN->value);
    }

    // Relations
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'author_id', 'uuid');
    }
}
