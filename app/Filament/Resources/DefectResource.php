<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DefectResource\Pages;
use App\Models\Defect;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DefectResource extends Resource
{
    protected static ?string $model = Defect::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static ?string $navigationGroup = 'Контент';

    protected static ?string $modelLabel = 'Поломка';

    protected static ?string $pluralModelLabel = 'Поломки';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Название')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('slug')
                ->label('Slug')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),
            Forms\Components\TextInput::make('description')
                ->label('Описание')
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('service_id')
                ->label('Привязанная услуга')
                ->relationship('service', 'name')
                ->searchable()
                ->preload()
                ->nullable(),
            Forms\Components\Toggle::make('is_active')
                ->label('Активна')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Название')->searchable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug'),
                Tables\Columns\TextColumn::make('description')->label('Описание')->limit(40),
                Tables\Columns\TextColumn::make('service.name')->label('Услуга'),
                Tables\Columns\IconColumn::make('is_active')->label('Активна')->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Активна'),
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
            'index' => Pages\ListDefects::route('/'),
            'create' => Pages\CreateDefect::route('/create'),
            'edit' => Pages\EditDefect::route('/{record}/edit'),
        ];
    }
}
