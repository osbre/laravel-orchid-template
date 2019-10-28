<?php

declare(strict_types=1);

use App\Http\Screens\WelcomeScreen;
use Domain\User\Screens\{
    RoleEditScreen,
    RoleListScreen,
};

use Domain\User\Screens\{
    UserCreateScreen as UserCreateScreen,
    UserEditScreen,
    UserListScreen
};

Route::screen('/main', WelcomeScreen::class)->name('platform.main');

Route::screen('users/{users}/edit', UserEditScreen::class)->name('platform.systems.users.edit');
Route::screen('users/create', UserCreateScreen::class)->name('platform.systems.users.create');
Route::screen('users', UserListScreen::class)->name('platform.systems.users');

Route::screen('roles/{roles}/edit', RoleEditScreen::class)->name('platform.systems.roles.edit');
Route::screen('roles/create', RoleEditScreen::class)->name('platform.systems.roles.create');
Route::screen('roles', RoleListScreen::class)->name('platform.systems.roles');
