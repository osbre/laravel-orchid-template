<?php

namespace Domain\User;

use Illuminate\Database\Eloquent\Relations\{BelongsToMany, HasMany};
use Orchid\Platform\Models\User as Authenticatable;

final class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
