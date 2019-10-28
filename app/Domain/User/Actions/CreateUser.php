<?php

namespace Domain\User\Actions;

use Domain\User\DataObjects\UserData;
use Domain\User\User;

final class CreateUser
{
    public function handle(UserData $userData, array $roles = null)
    {
        return User
            ::create($userData->toArray())
            ->replaceRoles($roles);
    }
}
