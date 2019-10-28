<?php

declare(strict_types=1);

namespace Domain\User\Layouts;

use Orchid\Screen\TD;
use Orchid\Platform\Models\User;
use Orchid\Screen\Layouts\Table;

class UserListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'users';

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            TD::set('id', 'ID')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->sort()
                ->link('platform.systems.users.edit', 'id'),

            TD::set('name', __('Name'))
                ->sort()
                ->filter(TD::FILTER_TEXT),

            TD::set('email', __('Email'))
                ->loadModalAsync('oneAsyncModal', 'saveUser', 'id', 'email')
                ->filter(TD::FILTER_TEXT)
                ->sort(),

            TD::set('updated_at', __('Last edit'))
                ->sort(),
        ];
    }
}
