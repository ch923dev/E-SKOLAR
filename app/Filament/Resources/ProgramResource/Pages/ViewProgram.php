<?php

namespace App\Filament\Resources\ProgramResource\Pages;

use App\Filament\Resources\ProgramResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProgram extends ViewRecord
{
    protected static string $resource = ProgramResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
