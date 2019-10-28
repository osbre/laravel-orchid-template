<?php

declare(strict_types=1);

namespace Domain\User\Layouts;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class UserPasswordLayout extends Rows
{
    /**
     * Views.
     *
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('user.password')
                ->type('password')
                ->required()
                ->horizontal()
                ->title(__('Password'))
                ->placeholder(__('Password')),
        ];
    }
}
