<?php

namespace App\Filament\Resources\ScholarshipOrganizationResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\ScholarshipOrganizationResource;

class ViewScholarshipOrganization extends ViewRecord
{
    protected static string $resource = ScholarshipOrganizationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
