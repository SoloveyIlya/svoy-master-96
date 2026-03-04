<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone-arrow-down-left';

    protected static ?string $navigationGroup = 'Заявки';

    protected static ?string $modelLabel = 'Заявка';

    protected static ?string $pluralModelLabel = 'Заявки';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Информация о заявке')->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Имя')
                    ->disabled(),
                Forms\Components\TextInput::make('phone')
                    ->label('Телефон')
                    ->disabled(),
                Forms\Components\Textarea::make('comment')
                    ->label('Комментарий клиента')
                    ->disabled()
                    ->rows(3),
                Forms\Components\TextInput::make('page_url')
                    ->label('URL страницы')
                    ->disabled(),
                Forms\Components\Select::make('landing_page_id')
                    ->label('Посадочная страница')
                    ->relationship('landingPage', 'slug')
                    ->disabled(),
            ]),

            Forms\Components\Section::make('Управление')->schema([
                Forms\Components\Select::make('status')
                    ->label('Статус')
                    ->options([
                        'new' => 'Новая',
                        'in_progress' => 'В работе',
                        'done' => 'Завершена',
                        'canceled' => 'Отменена',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('manager_comment')
                    ->label('Комментарий менеджера')
                    ->rows(3),
            ]),

            Forms\Components\Section::make('UTM-метки')->schema([
                Forms\Components\TextInput::make('utm_source')->label('Source')->disabled(),
                Forms\Components\TextInput::make('utm_medium')->label('Medium')->disabled(),
                Forms\Components\TextInput::make('utm_campaign')->label('Campaign')->disabled(),
                Forms\Components\TextInput::make('utm_term')->label('Term')->disabled(),
                Forms\Components\TextInput::make('utm_content')->label('Content')->disabled(),
                Forms\Components\Textarea::make('referer')->label('Referer')->disabled()->rows(2),
                Forms\Components\Textarea::make('user_agent')->label('User Agent')->disabled()->rows(2),
            ])->collapsible()->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Имя')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('Телефон')->searchable(),
                Tables\Columns\BadgeColumn::make('status')->label('Статус')
                    ->colors([
                        'info' => 'new',
                        'warning' => 'in_progress',
                        'success' => 'done',
                        'danger' => 'canceled',
                    ])
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'new' => 'Новая',
                        'in_progress' => 'В работе',
                        'done' => 'Завершена',
                        'canceled' => 'Отменена',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('page_url')->label('Страница')->limit(40),
                Tables\Columns\TextColumn::make('utm_source')->label('UTM Source')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')->label('Дата')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        'new' => 'Новая',
                        'in_progress' => 'В работе',
                        'done' => 'Завершена',
                        'canceled' => 'Отменена',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('От'),
                        Forms\Components\DatePicker::make('until')->label('До'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
