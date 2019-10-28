<?php

namespace Domain\User;

use Domain\Project\Project;
use Domain\Task\Task;
use Illuminate\Database\Eloquent\Relations\{BelongsToMany, HasMany};
use Orchid\Platform\Models\User as Authenticatable;

class User extends Authenticatable
{
    public const ADMIN_ROLE = 'admin';

    public function ownedProjects()
    {
        return $this->hasMany(Project::class,'owner_id');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function getSubTitle(): string
    {
        return '';
    }

    public function getHoursAttribute()
    {
        return $this->tasks->sum('hours');
    }
}
