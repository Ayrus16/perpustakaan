<?php

namespace App\Filament\Resources\BukuResource\Widgets;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\penulis;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as Widget;
use Illuminate\Support\Facades\Auth;

class StatOverview extends Widget
{
    // protected static string $view = 'filament.resources.buku-resource.widgets.stat-overview';

    protected function getStats(): array
    {
        // if($user->hasRole('admin')){
        //         return [
        //         Stat::make('Jumlah Buku', Buku::all()->count()),
        //         Stat::make('Jumlah Kategori', Kategori::all()->count()),
        //         Stat::make('Jumlah Penulis', penulis::all()->count()),
        //     ];

        // } else if ($user->hasRole('user')) {
        //     return [
        //         Stat::make('Jumlah Buku', Buku::where('users_id', Auth::user()->id)->count()),
        //     ];
        // }
                if(Auth::user()->hasRole('admin')){
                    return [
                        Stat::make('Jumlah Buku', Buku::all()->count()),
                        Stat::make('Jumlah Kategori', Kategori::all()->count()),
                        Stat::make('Jumlah Penulis', penulis::all()->count()),
                    ];
                } else{
                    return [
                        Stat::make('Jumlah Buku', Buku::where('users_id', Auth::user()->id)->count())
                    ];
                }
                
        
    }

}
