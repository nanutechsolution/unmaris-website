<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\LatestMessages;
use App\Filament\Widgets\NewsChart;
use App\Filament\Widgets\ProdiChart;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\VisitorStats;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\NavigationGroup as FilamentNavigationGroup;
use App\Enums\NavigationGroup;
use Filament\Support\Icons\Heroicon;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->authGuard('web')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->brandName('Admin UNMARIS')
            ->favicon(asset('images/logo-unmaris.png'))
            // 4. Navigasi Terlipat secara Default
            ->sidebarCollapsibleOnDesktop()
            ->collapsedSidebarWidth('9rem')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->navigationGroups([
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::Konten->value)
                    ->icon(Heroicon::OutlinedNewspaper)
                    ->collapsed(),
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::Akademik->value)
                    ->icon(Heroicon::OutlinedAcademicCap)
                    ->collapsed(),
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::Kemahasiswaan->value)
                    ->icon(Heroicon::OutlinedUserGroup)
                    ->collapsed(),
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::Kemitraan->value)
                    ->icon(Heroicon::OutlinedBuildingOffice)
                    ->collapsed(),
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::Sistem->value)
                    ->icon(Heroicon::OutlinedCog6Tooth)
                    ->collapsed(),
            ])
            ->widgets([
                StatsOverview::class,
                NewsChart::class,
                ProdiChart::class,
                VisitorStats::class,
                LatestMessages::class,
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
            ]);
    }
}
