<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImportRunResource\Pages;
use App\Models\ImportRun;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ImportRunResource extends Resource
{
    protected static ?string $model = ImportRun::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';

    protected static ?string $navigationGroup = 'Парсер';

    protected static ?string $modelLabel = 'Запуск парсера';

    protected static ?string $pluralModelLabel = 'История запусков';

    protected static ?int $navigationSort = 1;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->width(60),

                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'running' => 'warning',
                        'success' => 'success',
                        'failed'  => 'danger',
                        default   => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'running' => 'Выполняется',
                        'success' => 'Успешно',
                        'failed'  => 'Ошибка',
                        default   => $state,
                    }),

                Tables\Columns\TextColumn::make('seed_url')
                    ->label('Seed URL')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->seed_url),

                Tables\Columns\TextColumn::make('initiated_by')
                    ->label('Инициатор')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('started_at')
                    ->label('Старт')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable(),

                Tables\Columns\TextColumn::make('finished_at')
                    ->label('Завершён')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('stats_json.urls_discovered')
                    ->label('Найдено URL')
                    ->default(0)
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('stats_json.urls_parsed')
                    ->label('Распарсено')
                    ->default(0)
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('stats_json.items_extracted')
                    ->label('Извлечено')
                    ->default(0)
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('stats_json.new')
                    ->label('Новых')
                    ->default(0)
                    ->color('success')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('stats_json.updated')
                    ->label('Обновлено')
                    ->default(0)
                    ->color('info')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('stats_json.errors')
                    ->label('Ошибок')
                    ->default(0)
                    ->color('danger')
                    ->alignCenter(),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->poll('10s');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Информация о запуске')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('id')
                            ->label('ID'),

                        Infolists\Components\TextEntry::make('status')
                            ->label('Статус')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'running' => 'warning',
                                'success' => 'success',
                                'failed'  => 'danger',
                                default   => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'running' => 'Выполняется',
                                'success' => 'Успешно',
                                'failed'  => 'Ошибка',
                                default   => $state,
                            }),

                        Infolists\Components\TextEntry::make('initiated_by')
                            ->label('Инициатор'),

                        Infolists\Components\TextEntry::make('seed_url')
                            ->label('Seed URL')
                            ->columnSpanFull()
                            ->url(fn ($record) => $record->seed_url),

                        Infolists\Components\TextEntry::make('started_at')
                            ->label('Начало')
                            ->dateTime('d.m.Y H:i:s'),

                        Infolists\Components\TextEntry::make('finished_at')
                            ->label('Конец')
                            ->dateTime('d.m.Y H:i:s')
                            ->placeholder('Ещё выполняется'),
                    ]),

                Infolists\Components\Section::make('Статистика')
                    ->columns(6)
                    ->schema([
                        Infolists\Components\TextEntry::make('stats_json.urls_discovered')
                            ->label('URL найдено')
                            ->default(0),

                        Infolists\Components\TextEntry::make('stats_json.urls_fetched')
                            ->label('URL скачано')
                            ->default(0),

                        Infolists\Components\TextEntry::make('stats_json.urls_parsed')
                            ->label('URL распарсено')
                            ->default(0),

                        Infolists\Components\TextEntry::make('stats_json.items_extracted')
                            ->label('Извлечено записей')
                            ->default(0),

                        Infolists\Components\TextEntry::make('stats_json.new')
                            ->label('Новых лендингов')
                            ->color('success')
                            ->default(0),

                        Infolists\Components\TextEntry::make('stats_json.updated')
                            ->label('Обновлено')
                            ->color('info')
                            ->default(0),

                        Infolists\Components\TextEntry::make('stats_json.skipped')
                            ->label('Пропущено')
                            ->default(0),

                        Infolists\Components\TextEntry::make('stats_json.deactivated_models')
                            ->label('Деактивировано моделей')
                            ->default(0),

                        Infolists\Components\TextEntry::make('stats_json.deactivated_landings')
                            ->label('Деактивировано лендингов')
                            ->default(0),

                        Infolists\Components\TextEntry::make('stats_json.errors')
                            ->label('Ошибок')
                            ->color('danger')
                            ->default(0),
                    ]),

                Infolists\Components\Section::make('URL-адреса')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('urls')
                            ->label('')
                            ->schema([
                                Infolists\Components\TextEntry::make('url')
                                    ->label('URL')
                                    ->url(fn ($record) => $record->url)
                                    ->columnSpan(3),

                                Infolists\Components\TextEntry::make('status')
                                    ->label('Статус')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'new'    => 'gray',
                                        'fetched'  => 'info',
                                        'parsed' => 'success',
                                        'failed' => 'danger',
                                        default  => 'gray',
                                    }),

                                Infolists\Components\TextEntry::make('http_code')
                                    ->label('HTTP')
                                    ->placeholder('—'),

                                Infolists\Components\TextEntry::make('items_count')
                                    ->label('Записей')
                                    ->state(fn ($record) => $record->items()->count()),

                                Infolists\Components\TextEntry::make('error_text')
                                    ->label('Ошибка')
                                    ->color('danger')
                                    ->placeholder('—')
                                    ->columnSpan(2),
                            ])
                            ->columns(7),
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
            'index' => Pages\ListImportRuns::route('/'),
            'view'  => Pages\ViewImportRun::route('/{record}'),
        ];
    }
}
