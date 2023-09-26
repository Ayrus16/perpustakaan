<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriResource\RelationManagers\PostsRelationManager;
use App\Filament\Resources\PenulisResource\Pages;
use App\Filament\Resources\PenulisResource\RelationManagers;
use App\Models\Penulis;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
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

class PenulisResource extends Resource
{
    protected static ?string $model = Penulis::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Management';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make('nama_penulis')
                    ->reactive()
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', \Str::slug($state)))
                    ->required(),TextInput::make('slug')->required(),
                    RichEditor::make('cerita_singkat')->maxLength(255)
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
                TextColumn::make('nama_penulis')->limit(50)->sortable()
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
            'index' => Pages\ListPenulis::route('/'),
            'create' => Pages\CreatePenulis::route('/create'),
            'edit' => Pages\EditPenulis::route('/{record}/edit'),
        ];
    }    
}
