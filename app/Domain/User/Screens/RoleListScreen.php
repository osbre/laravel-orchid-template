<?php

declare(strict_types=1);

namespace Domain\User\Screens;

use Orchid\Screen\{Action, Screen, Actions\Link};
use Orchid\Platform\Models\Role;
use Domain\User\Layouts\RoleListLayout;

class RoleListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Roles';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Access rights';

    /**
     * @var string
     */
    public $permission = 'platform.systems.roles';

    /**
     * Query data.
     *
     * @return array
     */
    public function query() : array
    {
        return [
            'roles' => Role::filters()->defaultSort('id', 'desc')->paginate(),
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
                ->href(route('platform.systems.roles.create')),
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
            RoleListLayout::class,
        ];
    }
}
