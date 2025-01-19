<?php

namespace App\Filament\Resources\AirtableSourceResource\Pages;

use App\Filament\Resources\AirtableSourceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAirtableSources extends ListRecords
{
    protected static string $resource = AirtableSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
