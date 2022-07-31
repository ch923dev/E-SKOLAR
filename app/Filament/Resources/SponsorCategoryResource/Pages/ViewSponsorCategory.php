<?php

namespace App\Filament\Resources\SponsorCategoryResource\Pages;

use App\Filament\Resources\SponsorCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSponsorCategory extends ViewRecord
{
    protected static string $resource = SponsorCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
