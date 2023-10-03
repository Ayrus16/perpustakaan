<?php

namespace App\Filament\Resources\BukuResource\Pages;

use App\Filament\Resources\BukuResource;
use App\Models\Buku;
use Filament\Actions;
// use Filament\Forms\Components\Builder;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ListBukus extends ListRecords
{
    protected static string $resource = BukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BukuResource\Widgets\StatOverview::class,
        ];
    }

    protected function getTableQuery(): Builder 
    {

        if(Auth::user()->hasRole('admin')){
            return Buku::where('users_id', '!=' , '0');
        } else{
            return Buku::where('users_id', Auth::user()->id);
        }
            
    }
}
