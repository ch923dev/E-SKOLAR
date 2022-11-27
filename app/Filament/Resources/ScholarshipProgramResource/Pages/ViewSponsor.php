<?php

namespace App\Filament\Resources\ScholarshipProgramResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\ScholarshipProgramResource;

class ViewScholarshipProgram extends ViewRecord
{
    protected static string $resource = ScholarshipProgramResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
