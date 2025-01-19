<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Enums\RoleName;
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
                ->visible(fn () => ! in_array($this->record->name, [RoleName::ADMIN->value, RoleName::MEMBER->value])),
        ];
    }
}
