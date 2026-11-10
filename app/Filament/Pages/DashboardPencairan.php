<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class DashboardPencairan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard-pencairan';

    protected static ?string $navigationLabel = 'Dashboard Pencairan';

    protected static ?string $title = 'Dashboard Administrasi Pengajuan & Pencairan Dana';

    protected static ?int $navigationSort = -10;

    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()->status === 'aktif';
    }
}

