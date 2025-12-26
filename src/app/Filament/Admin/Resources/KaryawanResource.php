<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\KaryawanResource\Pages;
use App\Filament\Admin\Resources\KaryawanResource\RelationManagers;
use App\Models\Karyawan;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class KaryawanResource extends Resource
{
    protected static ?string $model = Karyawan::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Karyawan';
    protected static ?string $pluralModelLabel = 'Data Karyawan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                               Forms\Components\Section::make('Data Personal')
                    ->schema([
                        Forms\Components\TextInput::make('nama_lengkap')->required(),

                        Forms\Components\TextInput::make('nip')->label('NIP')->maxLength(30),
                        Forms\Components\TextInput::make('nuptk')->label('NUPTK')->maxLength(30),
                        Forms\Components\TextInput::make('nik')->label('NIK')->maxLength(30),

                        Forms\Components\Select::make('jenis_kelamin')
                            ->options([
                                'L' => 'Laki-Laki',
                                'P' => 'Perempuan',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('agama'),

                        Forms\Components\TextInput::make('tempat_lahir')
                            ->label('Tempat Lahir'),

                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->required(),
                        
                        Forms\Components\Select::make('sekolah_id')
                            ->label('Sekolah')
                            ->relationship('sekolah', 'nama_sekolah')
                            ->searchable(),

                    ]),

                Forms\Components\Section::make('Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('email_karyawan')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->label('Email Karyawan'),

                        Forms\Components\TextInput::make('no_hp')
                            ->label('No HP'),

                        Forms\Components\Textarea::make('alamat'),
                    ]),

                Forms\Components\Section::make('Detail Pekerjaan')
                    ->schema([
                        Forms\Components\Select::make('jabatan_id')
                            ->label('Jabatan')
                            ->relationship('jabatan', 'nama_jabatan')
                            ->searchable()
                            ->required(),

                        Forms\Components\TextInput::make('status_kepegawaian')
                            ->label('Status Kepegawaian (ASN/GTT/PTT/Honorer)'),

                        Forms\Components\TextInput::make('bidang_studi')
                            ->label('Bidang Studi/Guru Mapel'),

                        Forms\Components\TextInput::make('unit_kerja')
                            ->label('Unit Kerja'),
                    ]),
                    
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('jabatan.nama_jabatan')->label('Jabatan'),
                Tables\Columns\TextColumn::make('email_karyawan')->label('Email'),
                Tables\Columns\TextColumn::make('no_hp')->label('No HP'),
                Tables\Columns\TextColumn::make('status_kepegawaian')->label('Status'),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->date(),
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
            ]);
    }

    // Auto create USER login ketika membuat karyawan
    public static function beforeCreate($data)
    {
        $password = Carbon::parse($data['tanggal_lahir'])->format('Ymd');

        $user = User::create([
            'name'     => $data['nama_lengkap'],
            'email'    => $data['email_karyawan'],
            'password' => Hash::make($password),
        ]);

        $data['user_id'] = $user->id;

        return $data;
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
            'index' => Pages\ListKaryawans::route('/'),
            'create' => Pages\CreateKaryawan::route('/create'),
            'edit' => Pages\EditKaryawan::route('/{record}/edit'),
        ];
    }
}   