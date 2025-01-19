<?php

namespace App\Filament\Resources\JobPositionSourceResource\Pages;

use App\Filament\Resources\JobPositionSourceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobPositionSource extends EditRecord
{
    protected static string $resource = JobPositionSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
