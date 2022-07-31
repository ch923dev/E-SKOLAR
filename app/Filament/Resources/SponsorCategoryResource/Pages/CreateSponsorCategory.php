<?php

namespace App\Filament\Resources\SponsorCategoryResource\Pages;

use App\Filament\Resources\SponsorCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSponsorCategory extends CreateRecord
{
    protected static string $resource = SponsorCategoryResource::class;
    protected static bool $canCreateAnother = false;
}
