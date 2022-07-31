<?php

namespace App\Filament\Resources\SponsorResource\Pages;

use App\Filament\Resources\SponsorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSponsor extends CreateRecord
{
    protected static string $resource = SponsorResource::class;
    protected static bool $canCreateAnother = false;

}
