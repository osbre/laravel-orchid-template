<?php

declare(strict_types=1);

namespace Domain\User\Screens;

use Orchid\Screen\{Action, Layout, Screen, Actions\Button, Fields\Password, Actions\DropDown, Actions\ModalToggle};
use Domain\User\Queries\UserQueries;
use Illuminate\Http\Request;
use Orchid\Access\UserSwitch;
use Domain\User\User;
use Orchid\Support\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Domain\User\Layouts\{UserEditLayout, UserRoleLayout};

class UserEditScreen extends Screen
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
        $user->load(['roles']);

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
            DropDown::make(__('Settings'))
                ->icon('icon-open')
                ->list([
                    Button::make(__('Login as user'))
                        ->icon('icon-login')
                        ->method('loginAs'),

                    ModalToggle::make(__('Change Password'))
                        ->icon('icon-lock-open')
                        ->title(__('Change Password'))
                        ->method('changePassword')
                        ->modal('password'),
                ]),

            Button::make(__('Save'))
                ->icon('icon-check')
                ->method('save'),

            Button::make(__('Remove'))
                ->icon('icon-trash')
                ->method('remove'),
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
            UserRoleLayout::class,

            Layout::modal('password', [
                Layout::rows([
                    Password::make('password')
                        ->title(__('Password'))
                        ->required()
                        ->placeholder(__('Enter your password')),
                ]),
            ]),
        ];
    }

    /**
     * @param \Domain\User\User $user
     * @param \Illuminate\Http\Request     $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(User $user, Request $request)
    {
        UserQueries::update($user, $request);

        Alert::info(__('User was saved.'));

        return redirect()->route('platform.systems.users');
    }

    /**
     * @param User $user
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(User $user)
    {
        $user->delete();

        Alert::info(__('User was removed'));

        return redirect()->route('platform.systems.users');
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAs(User $user)
    {
        UserSwitch::loginAs($user);

        return redirect()->route(config('platform.index'));
    }

    /**
     * @param User    $user
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(User $user, Request $request)
    {
        $user->password = Hash::make($request->get('password'));
        $user->save();

        Alert::info(__('User was saved.'));

        return back();
    }
}
