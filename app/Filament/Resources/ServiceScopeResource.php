<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceScopeResource\Pages;
use App\Models\ServiceScope;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceScopeResource extends Resource
{
    protected static ?string $model = ServiceScope::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $navigationGroup = 'Контент';

    protected static ?string $modelLabel = 'Срез по услуге';

    protected static ?string $pluralModelLabel = 'Срезы по услугам';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Tabs')->tabs([
                Forms\Components\Tabs\Tab::make('Привязка')->schema([
                    Forms\Components\Select::make('scope_type')
                        ->label('Тип привязки')
                        ->options([
                            'category' => 'Категория',
                            'brand' => 'Бренд',
                        ])
                        ->required()
                        ->reactive(),
                    Forms\Components\Select::make('scope_id')
                        ->label('Категория')
                        ->options(fn () => \App\Models\Category::pluck('name', 'id'))
                        ->searchable()
                        ->visible(fn (Forms\Get $get) => $get('scope_type') === 'category')
                        ->required(),
                    Forms\Components\Select::make('scope_id')
                        ->label('Бренд')
                        ->options(fn () => \App\Models\Brand::pluck('name', 'id'))
                        ->searchable()
                        ->visible(fn (Forms\Get $get) => $get('scope_type') === 'brand')
                        ->required(),
                    Forms\Components\Select::make('service_id')
                        ->label('Услуга')
                        ->relationship('service', 'name')
                        ->required()
                        ->searchable()
                        ->preload(),
                    Forms\Components\Select::make('status')
                        ->label('Статус')
                        ->options([
                            'active' => 'Активен',
                            'inactive' => 'Неактивен',
                        ])
                        ->default('active')
                        ->required(),
                ]),
                Forms\Components\Tabs\Tab::make('Контент (override)')->schema([
                    Forms\Components\RichEditor::make('custom_intro')
                        ->label('Intro (override)')
                        ->helperText('Оставьте пустым для использования шаблона из услуги')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('custom_body')
                        ->label('Body (override)')
                        ->columnSpanFull(),
                    Forms\Components\KeyValue::make('custom_faq_json')
                        ->label('FAQ (override)')
                        ->keyLabel('Вопрос')
                        ->valueLabel('Ответ')
                        ->columnSpanFull(),
                ]),
                Forms\Components\Tabs\Tab::make('SEO (override)')->schema([
                    Forms\Components\TextInput::make('seo_title')
                        ->label('SEO Title')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('seo_description')
                        ->label('SEO Description')
                        ->rows(3),
                    Forms\Components\TextInput::make('seo_h1')
                        ->label('H1')
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('seo_bottom_text')
                        ->label('SEO Текст (внизу страницы)')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('canonical_url')
                        ->label('Canonical URL')
                        ->url()
                        ->maxLength(500),
                    Forms\Components\Toggle::make('noindex')
                        ->label('Noindex'),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('scope_type')->label('Тип')
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'category' => 'Категория',
                        'brand' => 'Бренд',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('scope_id')->label('ID привязки'),
                Tables\Columns\TextColumn::make('service.name')->label('Услуга'),
                Tables\Columns\BadgeColumn::make('status')->label('Статус')
                    ->colors(['success' => 'active', 'danger' => 'inactive']),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('scope_type')
                    ->label('Тип')
                    ->options(['category' => 'Категория', 'brand' => 'Бренд']),
                Tables\Filters\SelectFilter::make('service_id')
                    ->label('Услуга')
                    ->relationship('service', 'name'),
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
            'index' => Pages\ListServiceScopes::route('/'),
            'create' => Pages\CreateServiceScope::route('/create'),
            'edit' => Pages\EditServiceScope::route('/{record}/edit'),
        ];
    }
}
