<?php

namespace App\Filament\Resources\SponsorResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\SponsorResource;

class ViewSponsor extends ViewRecord
{
    protected static string $resource = SponsorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
