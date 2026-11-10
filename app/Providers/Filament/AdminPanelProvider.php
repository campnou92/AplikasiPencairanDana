<?php

namespace App\Providers\Filament;

use App\Filament\Pages\DashboardPencairan;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandName('Pencairan Dana INSTIPER')
            ->login(\App\Filament\Pages\Auth\Login::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                DashboardPencairan::class,
            ])
            ->navigationGroups([
                'Pengajuan & Registrasi',
                'Persetujuan (ACC)',
                'Pencairan & BKK',
                'Penerimaan Dana',
                'Arsip & Pembukuan',
                'Master Data',
                'Manajemen Sistem',
            ])
            ->navigationItems([
                NavigationItem::make('Input Pengajuan')
                    ->group('Pengajuan & Registrasi')
                    ->icon('heroicon-o-document-plus')
                    ->badge('Segera hadir', 'gray')
                    ->url('#')
                    ->visible(fn () => auth()->user()?->hasRole(['admin_pencairan'])),

                NavigationItem::make('Register Surat Masuk')
                    ->group('Pengajuan & Registrasi')
                    ->icon('heroicon-o-envelope')
                    ->badge('Segera hadir', 'gray')
                    ->url('#')
                    ->visible(fn () => auth()->user()?->hasRole(['admin_pencairan'])),

                NavigationItem::make('Rekap Harian')
                    ->group('Persetujuan (ACC)')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->badge('Segera hadir', 'gray')
                    ->url('#')
                    ->visible(fn () => auth()->user()?->hasRole(['admin_pencairan'])),

                NavigationItem::make('Persetujuan Bu Fitri')
                    ->group('Persetujuan (ACC)')
                    ->icon('heroicon-o-check-badge')
                    ->badge('Segera hadir', 'amber')
                    ->url('#')
                    ->visible(fn () => auth()->user()?->hasRole(['approver']) && ! auth()->user()?->hasRole('admin_it')),

                NavigationItem::make('Jadwal Pencairan')
                    ->group('Pencairan & BKK')
                    ->icon('heroicon-o-calendar-days')
                    ->badge('Segera hadir', 'gray')
                    ->url('#')
                    ->visible(fn () => auth()->user()?->hasRole(['admin_pencairan'])),

                NavigationItem::make('Buat BKK')
                    ->group('Pencairan & BKK')
                    ->icon('heroicon-o-document-text')
                    ->badge('Segera hadir', 'gray')
                    ->url('#')
                    ->visible(fn () => auth()->user()?->hasRole(['admin_pencairan'])),

                NavigationItem::make('Pembayaran')
                    ->group('Pencairan & BKK')
                    ->icon('heroicon-o-currency-dollar')
                    ->badge('Segera hadir', 'gray')
                    ->url('#')
                    ->visible(fn () => auth()->user()?->hasRole(['admin_pencairan'])),

                NavigationItem::make('Konfirmasi Penerimaan')
                    ->group('Penerimaan Dana')
                    ->icon('heroicon-o-check-circle')
                    ->badge('Segera hadir', 'gray')
                    ->url('#')
                    ->visible(fn () => auth()->user()?->hasRole(['penerima']) && ! auth()->user()?->hasRole('admin_it')),

                NavigationItem::make('Arsip BKK')
                    ->group('Arsip & Pembukuan')
                    ->icon('heroicon-o-archive-box')
                    ->badge('Segera hadir', 'gray')
                    ->url('#')
                    ->visible(fn () => auth()->user()?->hasRole(['admin_pencairan', 'keuangan_arsip', 'yayasan_arsip'])),

                NavigationItem::make('Antrean Pembukuan')
                    ->group('Arsip & Pembukuan')
                    ->icon('heroicon-o-book-open')
                    ->badge('Segera hadir', 'gray')
                    ->url('#')
                    ->visible(fn () => auth()->user()?->hasRole(['pembukuan'])),
            ])
            ->widgets([
                Widgets\AccountWidget::class,
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
