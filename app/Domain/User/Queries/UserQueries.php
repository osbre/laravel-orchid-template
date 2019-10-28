<?php

namespace Domain\User\Queries;

use Domain\User\DataObjects\UserData;
use Domain\User\User;
use Illuminate\Http\Request;

final class UserQueries
{
    public static function create(UserData $userData, array $roles = null)
    {
        return User::create($userData->toArray())->replaceRoles($roles);
    }

    public static function update(User $user, Request $request)
    {
        $permissions = $request->get('permissions', []);
        $roles = $request->input('user.roles', []);

        return $user->fill($request->get('user'))
            ->replaceRoles($roles)
            ->fill(['permissions' => UserData::formatPermissions($permissions)])
            ->save();
    }
}
