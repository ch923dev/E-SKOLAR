<?php

namespace App\Filament\Resources\SponsorCategoryResource\Pages;

use App\Filament\Resources\SponsorCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSponsorCategory extends EditRecord
{
    protected static string $resource = SponsorCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
