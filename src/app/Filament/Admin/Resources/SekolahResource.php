<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SekolahResource\Pages;
use App\Filament\Admin\Resources\SekolahResource\RelationManagers;
use App\Models\Sekolah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SekolahResource extends Resource
{
 protected static ?string $model = Sekolah::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Sekolah';
    protected static ?string $pluralModelLabel = 'Data Sekolah';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('npsn')
                    ->label('NPSN')
                    ->maxLength(20),

                Forms\Components\TextInput::make('nama_sekolah')
                    ->label('Nama Sekolah')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('alamat')
                    ->label('Alamat Sekolah')
                    ->rows(3),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            
                Tables\Columns\TextColumn::make('npsn')
                    ->label('NPSN')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_sekolah')
                    ->label('Nama Sekolah')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(40),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListSekolahs::route('/'),
            'create' => Pages\CreateSekolah::route('/create'),
            'edit' => Pages\EditSekolah::route('/{record}/edit'),
        ];
    }
}