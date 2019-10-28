<?php

namespace Domain\User\Actions;

use Domain\User\DataObjects\UserData;
use Domain\User\User;
use Illuminate\Http\Request;

final class UpdateUser
{
    public function handle(User $user, Request $request): bool
    {
        $permissions = $request->get('permissions', []);
        $roles = $request->input('user.roles', []);

        return $user->fill($request->get('user'))
            ->replaceRoles($roles)
            ->fill(['permissions' => UserData::formatPermissions($permissions)])
            ->save();
    }
}
