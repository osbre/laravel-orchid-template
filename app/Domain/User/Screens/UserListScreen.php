<?php

declare(strict_types=1);

namespace Domain\User\Screens;

use Orchid\Screen\{Actions\Link, Layout, Screen};
use Illuminate\Http\Request;
use Domain\User\User;
use Orchid\Support\Facades\Alert;
use Domain\User\Layouts\{UserEditLayout, UserListLayout, UserFiltersLayout};

class UserListScreen extends Screen
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
     * @return array
     */
    public function query() : array
    {
        return  [
            'users'  => User::with('roles')
                ->filters()
                ->filtersApplySelection(UserFiltersLayout::class)
                ->defaultSort('id', 'desc')
                ->paginate(),
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar() : array
    {
        return [
            Link::make(__('Add'))
                ->icon('icon-plus')
                ->href(route('platform.systems.users.create')),
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout() : array
    {
        return [
            UserFiltersLayout::class,
            UserListLayout::class,

            Layout::modal('oneAsyncModal', [
                UserEditLayout::class,
            ])->async('asyncGetUser'),
        ];
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function asyncGetUser(User $user) : array
    {
        return [
            'user' => $user,
        ];
    }

    /**
     * @param User    $user
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveUser(User $user, Request $request)
    {
        $user->fill($request->get('user'))
            ->save();

        Alert::info(__('User was saved.'));

        return back();
    }
}
