<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditLogResource\Pages;
use App\Models\AuditLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Manajemen Sistem';

    protected static ?string $navigationLabel = 'Log Audit Sistem';

    protected static ?string $modelLabel = 'Log Audit';

    protected static ?string $pluralModelLabel = 'Log Audit';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('actor')
                    ->label('Pelaku (Actor)')
                    ->disabled(),
                Forms\Components\TextInput::make('action')
                    ->label('Tindakan (Action)')
                    ->disabled(),
                Forms\Components\TextInput::make('entity')
                    ->label('Entitas')
                    ->disabled(),
                Forms\Components\TextInput::make('entity_id')
                    ->label('ID Entitas')
                    ->disabled(),
                Forms\Components\DateTimePicker::make('timestamp')
                    ->label('Waktu Kejadian')
                    ->disabled(),
                Forms\Components\Textarea::make('reason')
                    ->label('Alasan / Catatan')
                    ->disabled(),
                Forms\Components\KeyValue::make('before_after')
                    ->label('Perubahan Data (Before / After)')
                    ->disabled()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('log_id')
                    ->label('No')
                    ->sortable(),
                Tables\Columns\TextColumn::make('timestamp')
                    ->label('Waktu')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
                Tables\Columns\TextColumn::make('actor')
                    ->label('Pelaku')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('action')
                    ->label('Aksi')
                    ->badge()
                    ->colors([
                        'success' => fn ($state) => in_array($state, ['created', 'login']),
                        'warning' => 'updated',
                        'danger' => fn ($state) => in_array($state, ['deleted', 'login_blocked_inactive', 'login_failed']),
                        'info' => fn ($state) => ! in_array($state, ['created', 'login', 'updated', 'deleted']),
                    ]),
                Tables\Columns\TextColumn::make('entity')
                    ->label('Entitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('entity_id')
                    ->label('ID Target'),
                Tables\Columns\TextColumn::make('reason')
                    ->label('Alasan')
                    ->limit(40)
                    ->searchable(),
            ])
            ->defaultSort('log_id', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('action')
                    ->options([
                        'created' => 'Created',
                        'updated' => 'Updated',
                        'deleted' => 'Deleted',
                        'login' => 'Login',
                        'login_failed' => 'Login Gagal',
                        'login_blocked_inactive' => 'Login Terblokir',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditLogs::route('/'),
            'view' => Pages\ViewAuditLog::route('/{record}'),
        ];
    }
}

