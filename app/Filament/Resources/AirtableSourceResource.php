<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AirtableSourceResource\Pages;
use App\Models\AirtableSource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AirtableSourceResource extends Resource
{
    protected static ?string $model = AirtableSource::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Administration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('base_id')
                    ->required()
                    ->maxLength(255)
                    ->helperText('The Airtable Base ID from the API URL'),
                Forms\Components\TextInput::make('table_id')
                    ->required()
                    ->maxLength(255)
                    ->helperText('The Airtable Table ID from the API URL'),
                Forms\Components\TextInput::make('api_key')
                    ->required()
                    ->maxLength(255)
                    ->password()
                    ->helperText('Your Airtable API key'),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('base_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('table_id')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('last_synced_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('sync')
                    ->action(function (AirtableSource $record): void {
                        app(AirtableService::class)->syncJobPositions($record);
                    })
                    ->icon('heroicon-o-arrow-path')
                    ->requiresConfirmation(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAirtableSources::route('/'),
            'create' => Pages\CreateAirtableSource::route('/create'),
            'edit' => Pages\EditAirtableSource::route('/{record}/edit'),
        ];
    }
}
