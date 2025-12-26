<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\siswaResource\Pages;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class siswaResource extends Resource
{
    protected static ?string $model = siswa::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Data Sekolah';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('super_admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Siswa')
                    ->schema([
                        Forms\Components\TextInput::make('nama_lengkap')
                            ->required()
                            ->label('Nama Lengkap'),
                        Forms\Components\TextInput::make('nis')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->label('NIS'),
                        Forms\Components\TextInput::make('nisn')
                            ->numeric()
                            ->label('NISN'),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->options(['L'=>'Laki-laki','P'=>'Perempuan'])
                            ->required()
                            ->label('Jenis Kelamin'),
                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->required()
                            ->label('Tanggal Lahir'),
                        Forms\Components\TextInput::make('tempat_lahir')->label('Tempat Lahir'),
                        Forms\Components\TextInput::make('jurusan')->label('Jurusan'),
                        Forms\Components\TextInput::make('tahun_lulus')
                            ->numeric()
                            ->label('Tahun Lulus'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Status & Verifikasi')
                    ->collapsed()
                    ->schema([
                        Forms\Components\Select::make('status_verifikasi')
                            ->label('Status Verifikasi')
                            ->options([
                                'Belum Upload' => 'Belum Upload',
                                'Sedang Diverifikasi' => 'Sedang Diverifikasi',
                                'Terverifikasi' => 'Terverifikasi',
                                'Gagal' => 'Gagal',
                            ])
                            ->required(),

                        Forms\Components\Textarea::make('catatan_verifikasi')
                            ->label('Catatan Verifikasi'),

                        Forms\Components\Textarea::make('ocr_result')
                            ->label('Hasil OCR Mentah')
                            ->disabled()
                            ->placeholder('Hasil OCR akan muncul di sini setelah proses OCR selesai'),

                        Forms\Components\Placeholder::make('ijazah_preview')
                            ->label('Preview Ijazah')
                            ->content(fn ($record) => view('filament.admin.siswa.ijazah-preview', [
                                'record' => $record
                            ])),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')->searchable(),
                Tables\Columns\TextColumn::make('nis')->searchable(),
                Tables\Columns\TextColumn::make('jurusan'),
                Tables\Columns\TextColumn::make('tahun_lulus'),
                Tables\Columns\BadgeColumn::make('status_verifikasi')
                    ->colors([
                        'gray' => 'Belum Upload',
                        'warning' => 'Sedang Diverifikasi',
                        'success' => 'Terverifikasi',
                        'danger' => 'Gagal',
                    ]),
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\Listsiswas::route('/'),
            'create' => Pages\Createsiswa::route('/create'),
            'edit' => Pages\Editsiswa::route('/{record}/edit'),
        ];
    }
}