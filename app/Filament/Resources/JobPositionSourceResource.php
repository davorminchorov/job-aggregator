<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobPositionSourceResource\Pages;
use App\Models\JobPositionSource;
use App\Models\JobPositionSourceType;
use App\Services\JobPositionSourceFactory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JobPositionSourceResource extends Resource
{
    protected static ?string $model = JobPositionSource::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Job Sources';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('job_position_source_type_id')
                    ->relationship('sourceType', 'name')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state) {
                            $sourceType = JobPositionSourceType::find($state);
                            $set('credentials', array_fill_keys(array_keys($sourceType->required_fields ?? []), ''));
                        }
                    }),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\KeyValue::make('credentials')
                    ->required()
                    ->hiddenLabel()
                    ->rules(['array'])
                    ->beforeStateDehydrated(function ($state) {
                        return array_map(function ($value) {
                            return is_string($value) ? trim($value) : $value;
                        }, $state ?? []);
                    }),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sourceType.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
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
                    ->action(function (JobPositionSource $record): void {
                        $factory = app(JobPositionSourceFactory::class);
                        $source = $factory->make($record);
                        $source->sync($record);
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
            'index' => Pages\ListJobPositionSources::route('/'),
            'create' => Pages\CreateJobPositionSource::route('/create'),
            'edit' => Pages\EditJobPositionSource::route('/{record}/edit'),
        ];
    }
}
