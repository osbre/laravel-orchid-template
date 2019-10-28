<?php

declare(strict_types=1);

namespace App\Composers;

use Orchid\Platform\Menu;
use Orchid\Platform\ItemMenu;
use Orchid\Platform\Dashboard;

class MainMenuComposer
{
    /**
     * @var Dashboard
     */
    private $dashboard;

    /**
     * MenuComposer constructor.
     *
     * @param Dashboard $dashboard
     */
    public function __construct(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    /**
     * Registering the main menu items.
     */
    public function compose()
    {
        // Profile
        $this->dashboard->menu
            ->add(Menu::PROFILE,
                ItemMenu::label('Empty 1')
                    ->icon('icon-compass')
            )
            ->add(Menu::PROFILE,
                ItemMenu::label('Empty 2')
                    ->icon('icon-heart')
                    ->badge(function () {
                        return 6;
                    })
            )->add(Menu::MAIN,
                ItemMenu::label('Users')
                    ->icon('icon-user')
                    ->route('platform.systems.users')
                    ->title('General')
                    ->permission('platform.systems.users')
            )->add(Menu::MAIN,
                ItemMenu::label('Roles')
                    ->icon('icon-lock')
                    ->route('platform.systems.roles')
                    ->permission('platform.systems.roles')
            );

        // Main
        $this->dashboard->menu
            ->add(Menu::MAIN,
                ItemMenu::label('Example')
                    ->icon('icon-folder')
                    ->route('platform.main')
                    ->title('Example boilerplate')
            );
    }
}
