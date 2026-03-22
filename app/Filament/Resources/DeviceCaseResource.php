<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceCaseResource\Pages;
use App\Models\DeviceCase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DeviceCaseResource extends Resource
{
    protected static ?string $model = DeviceCase::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Контент';
    protected static ?string $modelLabel = 'Пример работы';
    protected static ?string $pluralModelLabel = 'Примеры работ';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required()->maxLength(255)->label('Заголовок'),
                Forms\Components\Textarea::make('description')->maxLength(65535)->columnSpanFull()->label('Описание'),
                Forms\Components\FileUpload::make('image_before')->image()->directory('cases')->label('Фото до'),
                Forms\Components\FileUpload::make('image_after')->image()->directory('cases')->label('Фото после'),
                Forms\Components\TextInput::make('price')->numeric()->prefix('₽')->label('Цена'),
                Forms\Components\TextInput::make('duration')->maxLength(255)->label('Сроки'),
                Forms\Components\Toggle::make('is_published')->default(true)->label('Опубликовано'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_after')->label('Фото'),
                Tables\Columns\TextColumn::make('title')->searchable()->label('Заголовок'),
                Tables\Columns\TextColumn::make('price')->money('rub')->sortable()->label('Цена'),
                Tables\Columns\TextColumn::make('duration')->searchable()->label('Сроки'),
                Tables\Columns\IconColumn::make('is_published')->boolean()->label('Опубликовано'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeviceCases::route('/'),
            'create' => Pages\CreateDeviceCase::route('/create'),
            'edit' => Pages\EditDeviceCase::route('/{record}/edit'),
        ];
    }
}
