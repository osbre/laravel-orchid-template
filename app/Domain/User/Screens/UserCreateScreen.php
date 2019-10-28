<?php

declare(strict_types=1);

namespace Domain\User\Screens;

use Orchid\Screen\{Action, Layout, Screen, Actions\Button};
use Domain\User\DataObjects\UserData;
use Domain\User\Queries\UserQueries;
use Illuminate\Http\{RedirectResponse, Request};
use Domain\User\User;
use Orchid\Support\Facades\Alert;
use Domain\User\Layouts\{UserEditLayout, UserPasswordLayout, UserRoleLayout};

class UserCreateScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'User';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'All registered users';

    /**
     * @var string
     */
    public $permission = 'platform.systems.users';

    /**
     * Query data.
     *
     * @param \Orchid\Platform\Models\User $user
     *
     * @return array
     */
    public function query(User $user): array
    {
        return [
            'user'       => $user,
            'permission' => $user->getStatusPermission(),
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make(__('Save'))
                ->icon('icon-check')
                ->method('save'),
        ];
    }

    /**
     * @throws \Throwable
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            UserEditLayout::class,
            UserPasswordLayout::class,
            UserRoleLayout::class,
        ];
    }

    /**
     * @param  User  $user
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function save(User $user, Request $request): RedirectResponse
    {
        UserQueries::create(
            UserData::fromRequest($request),
            $request->input('user.roles', [])
        );

        Alert::info(__('User was saved.'));

        return redirect()->route('platform.systems.users');
    }
}
