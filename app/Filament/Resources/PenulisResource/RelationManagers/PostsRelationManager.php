<?php

namespace App\Filament\Resources\PenulisResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Contracts\HasTable as ContractsHasTable;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function form(Form $form): Form
    {
        return $form
        ->schema([

            Section::make()->schema([
            TextInput::make('judul_buku')
            ->reactive()
            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', \Str::slug($state)))
            ->required(),TextInput::make('slug')->required(),

            SpatieMediaLibraryFileUpload::make('sampul')->image()->required(),

            Select::make('kategori_id')
            ->relationship(name: 'kategori', titleAttribute: 'nama_kategori')->required(),
            RichEditor::make('sinopsis')->required(),
            Select::make('penerbit_id')
            ->relationship(name: 'penerbit', titleAttribute: 'nama_penerbit')->required(),
            Select::make('penulis_id')
            ->relationship(name: 'penulis', titleAttribute: 'nama_penulis')->required(),
            ])
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('judul_buku')
            ->columns([
                TextColumn::make('No')->state(
                    static function (ContractsHasTable $livewire,  $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * (
                                $livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                SpatieMediaLibraryImageColumn::make('sampul'),


                TextColumn::make('judul_buku')->limit(50)->sortable(),
                TextColumn::make('penulis.nama_penulis')->limit(50)->sortable(),
                TextColumn::make('kategori.nama_kategori')->limit(50)->sortable(),
                TextColumn::make('penerbit.nama_penerbit')->limit(50)->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
}
