<?php

namespace App\Filament\Pages\Auth;

use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Auth\Pages\Login as BaseLogin;

class LoginPage extends BaseLogin
{
    public function getHeading(): string|Htmlable
    {
        return __('Pendaftaran Yudisium');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([]);
    }

    protected function getFormActions(): array
    {
        return [];
    }
}
