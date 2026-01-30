<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Enums\ThemeMode;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use App\Filament\Pages\Auth\LoginPage;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Swis\Filament\Backgrounds\ImageProviders\MyImages;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Swis\Filament\Backgrounds\FilamentBackgroundsPlugin;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            // ->path('admin')
            ->favicon(asset('https://feb.warmadewa.ac.id/wp-content/uploads/2025/11/LOGO-FEB-warmadewa.png'))
            ->brandLogo(asset('https://feb.warmadewa.ac.id/wp-content/uploads/2025/11/LOGO-FEB-warmadewa.png'))
            ->brandLogoHeight('7rem')
            ->login(LoginPage::class)
            // ->registration()
            // ->passwordReset()
            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
                fn() => view('auth.socialite.google'),
            )
            // ->renderHook(
            //     PanelsRenderHook::AUTH_REGISTER_FORM_AFTER,
            //     fn() => view('auth.socialite.google'),
            // )
            ->colors([
                'primary' => [
                    50  => '#f2f8fb',
                    100 => '#d9edf5',
                    200 => '#b3daeb',
                    300 => '#80bedb',
                    400 => '#4da2cb',
                    500 => '#106196',
                    600 => '#0e5687',
                    700 => '#0b476f',
                    800 => '#083857',
                    900 => '#052940',
                    950 => '#021a28',
                ],
            ])
            ->defaultThemeMode(ThemeMode::Light)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->plugins([
                FilamentBackgroundsPlugin::make()
                    ->remember(900)->imageProvider(
                        MyImages::make()
                            ->directory('assets/backgrounds')
                    ),
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                // AccountWidget::class,
                // FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
}
