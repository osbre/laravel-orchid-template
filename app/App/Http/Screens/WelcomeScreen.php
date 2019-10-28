<?php

declare(strict_types=1);

namespace App\Http\Screens;

use Orchid\Screen\{Layout, Screen};

class WelcomeScreen extends Screen
{
    /** @var string */
    public $name = 'Dashboard';

    /** @var string */
    public $description = 'Welcome';

    public function query(): array
    {
        return [];
    }

    public function commandBar(): array
    {
        return [];
    }

    public function layout(): array
    {
        return [
            Layout::view('welcome'),
        ];
    }
}
