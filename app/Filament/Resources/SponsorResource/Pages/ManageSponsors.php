<?php

namespace App\Filament\Resources\SponsorResource\Pages;

use App\Filament\Resources\SponsorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSponsors extends ManageRecords
{
    protected static string $resource = SponsorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
