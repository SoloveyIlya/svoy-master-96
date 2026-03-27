<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Каталог';

    protected static ?string $modelLabel = 'Категория';

    protected static ?string $pluralModelLabel = 'Категории';

    protected static ?int $navigationSort = 1;

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
                ]),
                Forms\Components\Tabs\Tab::make('SEO')->schema([
                    Forms\Components\TextInput::make('seo_title')
                        ->label('SEO Title')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('seo_description')
                        ->label('SEO Description')
                        ->rows(3),
                    Forms\Components\TextInput::make('seo_h1')
                        ->label('H1')
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('seo_intro')
                        ->label('Intro текст')
                        ->columnSpanFull(),
                    Forms\Components\KeyValue::make('seo_faq_json')
                        ->label('FAQ (вопрос → ответ)')
                        ->keyLabel('Вопрос')
                        ->valueLabel('Ответ')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('canonical_url')
                        ->label('Canonical URL')
                        ->url()
                        ->maxLength(500),
                    Forms\Components\Toggle::make('noindex')
                        ->label('Noindex'),
                    Forms\Components\RichEditor::make('seo_bottom_text')
                        ->label('SEO Текст (внизу страницы)')
                        ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('slug')->label('Slug')->searchable(),
                Tables\Columns\BadgeColumn::make('status')->label('Статус')
                    ->colors(['success' => 'active', 'danger' => 'inactive']),
                Tables\Columns\TextColumn::make('created_at')->label('Создано')->dateTime('d.m.Y'),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
