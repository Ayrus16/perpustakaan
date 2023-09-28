<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BukuResource\Pages;
use App\Filament\Resources\BukuResource\RelationManagers;
use App\Filament\Resources\BukuResource\Widgets\StatOverview;
use App\Models\Buku;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;

class BukuResource extends Resource
{
    protected static ?string $model = Buku::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    // protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()->schema([
                TextInput::make('judul_buku')
                    ->reactive()->required()->unique(column: 'judul_buku')
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', \Str::slug($state))),
                    TextInput::make('slug')->required()->disabled(),

                SpatieMediaLibraryFileUpload::make('sampul')->image()->required(),

                Select::make('kategori_id')
                    ->relationship(name: 'kategori', titleAttribute: 'nama_kategori')->searchable(['nama_kategori'])
                    ->required(),
                RichEditor::make('sinopsis')->required()->maxLength(900),
                Select::make('penerbit_id')
                    ->relationship(name: 'penerbit', titleAttribute: 'nama_penerbit')
                    ->searchable(['nama_penerbit'])
                    ->required(),
                Select::make('penulis_id')
                    ->relationship(name: 'penulis', titleAttribute: 'nama_penulis')
                    ->searchable(['nama_penulis'])
                    ->required(),

                Hidden::make('users_id')
                    ->default(Auth::user()->id)
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
                SpatieMediaLibraryImageColumn::make('sampul'),


                TextColumn::make('judul_buku')->limit(50)->sortable()->searchable(),
                TextColumn::make('penulis.nama_penulis')->limit(50)->sortable(),
                TextColumn::make('kategori.nama_kategori')->limit(50)->sortable(),
                TextColumn::make('penerbit.nama_penerbit')->limit(50)->sortable(),
            ])
            ->filters([
                SelectFilter::make('penulis')
                    ->relationship('penulis', 'nama_penulis'),
                SelectFilter::make('kategori')
                    ->relationship('kategori', 'nama_kategori'),
                SelectFilter::make('penerbit')
                    ->relationship('penerbit', 'nama_penerbit')
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
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBukus::route('/'),
            'create' => Pages\CreateBuku::route('/create'),
            'edit' => Pages\EditBuku::route('/{record}/edit'),
        ];
    }  
    
    public static function getWidgets(): array
    {
        return[
            StatOverview::class
        ];
    }
    
}
