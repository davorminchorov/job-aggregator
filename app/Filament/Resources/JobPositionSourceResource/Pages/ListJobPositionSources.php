<?php

namespace App\Filament\Resources\JobPositionSourceResource\Pages;

use App\Filament\Resources\JobPositionSourceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobPositionSources extends ListRecords
{
    protected static string $resource = JobPositionSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
