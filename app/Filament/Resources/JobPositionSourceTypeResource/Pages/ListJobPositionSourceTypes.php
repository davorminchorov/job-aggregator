<?php

namespace App\Filament\Resources\JobPositionSourceTypeResource\Pages;

use App\Filament\Resources\JobPositionSourceTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobPositionSourceTypes extends ListRecords
{
    protected static string $resource = JobPositionSourceTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
