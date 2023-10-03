<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriResource\RelationManagers\PostsRelationManager;
use App\Filament\Resources\PenerbitResource\Pages;
use App\Filament\Resources\PenerbitResource\RelationManagers;
use App\Models\Penerbit;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Contracts\HasTable;
class PenerbitResource extends Resource
{
    protected static ?string $model = Penerbit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Management';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section::make()->schema([
                //     TextInput::make('nama_penerbit')
                //     ->reactive()
                //     ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', \Str::slug($state)))
                //     ->required(),
                //     TextInput::make('slug')->required(),
                //     TextInput::make('kota'),
                //     TextInput::make('alamat_penerbit')
                //  ])
                 Section::make()
                 ->columns([
                     'sm' => 1,
                     'xl' => 2,
                     '2xl' => 2,
                 ])
                 ->schema([
                    TextInput::make('nama_penerbit')
                    ->reactive()
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', \Str::slug($state)))
                    ->required()->columnSpanFull(),
                    Hidden::make('slug')->required(),
                    TextInput::make('kota'),
                    TextInput::make('alamat_penerbit')
                 ])


        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->state(
                    static function (HasTable $livewire,  $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * (
                                $livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                TextColumn::make('nama_penerbit')->limit(50)->sortable(),
                TextColumn::make('kota')->limit(50)->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            PostsRelationManager::class
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenerbits::route('/'),
            'create' => Pages\CreatePenerbit::route('/create'),
            'edit' => Pages\EditPenerbit::route('/{record}/edit'),
        ];
    }    
}
