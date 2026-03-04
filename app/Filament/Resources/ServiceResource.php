<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationGroup = 'Каталог';

    protected static ?string $modelLabel = 'Услуга';

    protected static ?string $pluralModelLabel = 'Услуги';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Tabs')->tabs([
                Forms\Components\Tabs\Tab::make('Основное')->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Название')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                    Forms\Components\Select::make('status')
                        ->label('Статус')
                        ->options([
                            'active' => 'Активна',
                            'inactive' => 'Неактивна',
                        ])
                        ->default('active')
                        ->required(),
                    Forms\Components\TextInput::make('price_from')
                        ->label('Цена от')
                        ->maxLength(50),
                    Forms\Components\TextInput::make('duration_text')
                        ->label('Срок выполнения')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('warranty_text')
                        ->label('Гарантия')
                        ->maxLength(255),
                ]),
                Forms\Components\Tabs\Tab::make('Шаблонный контент')->schema([
                    Forms\Components\RichEditor::make('default_intro')
                        ->label('Intro по умолчанию')
                        ->helperText('Доступны переменные: {category}, {brand}, {model}, {service}, {city}')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('default_body')
                        ->label('Body по умолчанию')
                        ->helperText('Доступны переменные: {category}, {brand}, {model}, {service}, {city}')
                        ->columnSpanFull(),
                    Forms\Components\KeyValue::make('default_faq_json')
                        ->label('FAQ по умолчанию (вопрос → ответ)')
                        ->keyLabel('Вопрос')
                        ->valueLabel('Ответ')
                        ->columnSpanFull(),
                ]),
                Forms\Components\Tabs\Tab::make('SEO шаблоны')->schema([
                    Forms\Components\TextInput::make('seo_title')
                        ->label('SEO Title шаблон')
                        ->helperText('Переменные: {category}, {brand}, {model}, {service}, {city}')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('seo_description')
                        ->label('SEO Description шаблон')
                        ->helperText('Переменные: {category}, {brand}, {model}, {service}, {city}')
                        ->rows(3),
                    Forms\Components\TextInput::make('seo_h1')
                        ->label('H1 шаблон')
                        ->helperText('Переменные: {category}, {brand}, {model}, {service}, {city}')
                        ->maxLength(255),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Название')->searchable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug'),
                Tables\Columns\TextColumn::make('price_from')->label('Цена от'),
                Tables\Columns\BadgeColumn::make('status')->label('Статус')
                    ->colors(['success' => 'active', 'danger' => 'inactive']),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['active' => 'Активна', 'inactive' => 'Неактивна']),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
