<?php

namespace App\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Widgets\Widget;

class WelcomeWidget extends Widget
{
    protected string $view = 'filament.widgets.welcome-widget';
    protected int | string | array $columnSpan = 'full';
}
