<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function (Role $record) {
                    // Prevent deletion of admin and member roles
                    if (in_array($record->name, ['admin', 'member'])) {
                        return false;
                    }
                }),
        ];
    }
}
