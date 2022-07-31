<?php

namespace App\Filament\Resources\SponsorCategoryResource\Pages;

use App\Filament\Resources\SponsorCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSponsorCategories extends ListRecords
{
    protected static string $resource = SponsorCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
