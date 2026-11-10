<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppSettingResource\Pages;
use App\Models\AppSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppSettingResource extends Resource
{
    protected static ?string $model = AppSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Pengaturan Format & Nomor';

    protected static ?string $modelLabel = 'Pengaturan';

    protected static ?string $pluralModelLabel = 'Pengaturan & Format Nomor';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->label('Kunci Pengaturan (Key)')
                    ->required()
                    ->disabled(fn (?AppSetting $record) => $record !== null)
                    ->maxLength(255),
                Forms\Components\TextInput::make('value')
                    ->label('Nilai Pengaturan (Value)')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Contoh: REQ/{tahun}/{urut} atau BKK/{tahun_anggaran}/{urut}'),
                Forms\Components\TextInput::make('description')
                    ->label('Deskripsi / Keterangan')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Kunci (Key)')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Nilai (Value)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Keterangan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppSettings::route('/'),
            'create' => Pages\CreateAppSetting::route('/create'),
            'edit' => Pages\EditAppSetting::route('/{record}/edit'),
        ];
    }
}

