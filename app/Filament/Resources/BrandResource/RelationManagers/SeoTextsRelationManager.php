<?php

namespace App\Filament\Resources\BrandResource\RelationManagers;

use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SeoTextsRelationManager extends RelationManager
{
    protected static string $relationship = 'seoTexts';

    protected static ?string $title = 'SEO-тексты по категориям';

    protected static ?string $modelLabel = 'SEO-текст';

    protected static ?string $pluralModelLabel = 'SEO-тексты';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('category_id')
                ->label('Категория')
                ->options(Category::where('status', 'active')->orderBy('name')->pluck('name', 'id'))
                ->required()
                ->searchable()
                ->columnSpanFull(),
            Forms\Components\RichEditor::make('seo_bottom_text')
                ->label('SEO Текст (внизу страницы)')
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Категория')
                    ->sortable(),
                Tables\Columns\TextColumn::make('seo_bottom_text')
                    ->label('Текст')
                    ->limit(80)
                    ->html(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Обновлён')
                    ->dateTime('d.m.Y'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
