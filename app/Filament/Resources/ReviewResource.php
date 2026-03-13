<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static ?string $navigationGroup = 'Контент';

    protected static ?string $modelLabel = 'Отзыв';

    protected static ?string $pluralModelLabel = 'Отзывы';

    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('client_name')
                ->label('Имя клиента')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('device_name')
                ->label('Устройство/услуга')
                ->maxLength(255),

            Forms\Components\Textarea::make('text')
                ->label('Текст отзыва')
                ->required()
                ->rows(4),

            Forms\Components\Select::make('rating')
                ->label('Оценка')
                ->options([
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                ])
                ->default(5)
                ->required(),

            Forms\Components\Toggle::make('is_published')
                ->label('Опубликован')
                ->default(true),

            Forms\Components\DatePicker::make('published_at')
                ->label('Дата публикации'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('client_name')
                    ->label('Имя клиента')
                    ->searchable(),

                Tables\Columns\TextColumn::make('text')
                    ->label('Текст')
                    ->limit(80)
                    ->tooltip(fn (Review $record): string => $record->text),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Оценка')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_published')
                    ->label('Опубликован'),
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
