<?php

declare(strict_types=1);

namespace Domain\User\Screens;

use Orchid\Screen\{Screen, Actions\Button};
use Domain\User\Actions\CreateUser;
use Domain\User\DataObjects\UserData;
use Illuminate\Http\{RedirectResponse, Request};
use Domain\User\User;
use Orchid\Support\Facades\Alert;
use Domain\User\Layouts\{UserEditLayout, UserPasswordLayout, UserRoleLayout};

class UserCreateScreen extends Screen
{
    /** @var string */
    public $name = 'User';

    /** @var string */
    public $description = 'All registered users';

    /** @var string */
    public $permission = 'platform.systems.users';

    public function query(User $user): array
    {
        return [
            'user'       => $user,
            'permission' => $user->getStatusPermission(),
        ];
    }

    public function commandBar(): array
    {
        return [
            Button::make(__('Save'))
                ->icon('icon-check')
                ->method('save'),
        ];
    }

    public function layout(): array
    {
        return [
            UserEditLayout::class,
            UserPasswordLayout::class,
            UserRoleLayout::class,
        ];
    }

    public function save(User $user, Request $request, CreateUser $createUser): RedirectResponse
    {
        $createUser->handle(
            UserData::fromRequest($request),
            $request->input('user.roles', [])
        );

        Alert::info(__('User was saved.'));

        return redirect()->route('platform.systems.users');
    }
}
