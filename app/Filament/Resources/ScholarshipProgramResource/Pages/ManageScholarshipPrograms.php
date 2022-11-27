<?php

namespace App\Filament\Resources\ScholarshipProgramResource\Pages;

use App\Filament\Resources\ScholarshipProgramResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageScholarshipPrograms extends ManageRecords
{
    protected static string $resource = ScholarshipProgramResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
