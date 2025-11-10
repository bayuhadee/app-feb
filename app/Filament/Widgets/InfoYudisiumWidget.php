<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class InfoYudisiumWidget extends Widget
{
    protected string $view = 'filament.widgets.info-yudisium-widget';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;

    public static function canView(): bool
    {
        $user = Auth::user();
        return $user && $user->mahasiswa && Auth::user()->mahasiswa->yudisium;
    }

    protected function getViewData(): array
    {
        // Ambil data dari relasi user -> mahasiswa -> yudisium
        $yudisium = Auth::user()->mahasiswa->yudisium ?? null;

        return [
            'yudisium' => $yudisium,
        ];
    }
}
