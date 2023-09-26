<?php

namespace App\Filament\Resources\BukuResource\Widgets;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\penulis;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as Widget;

class StatOverview extends Widget
{
    // protected static string $view = 'filament.resources.buku-resource.widgets.stat-overview';

    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Buku', Buku::all()->count()),
            Stat::make('Jumlah Kategori', Kategori::all()->count()),
            Stat::make('Jumlah Penulis', penulis::all()->count()),
        ];
    }

}
