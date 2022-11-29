<?php

namespace App\Filament\Resources\ScholarResource\Pages;

use App\Filament\Resources\ScholarResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageScholars extends ManageRecords
{
    protected static string $resource = ScholarResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
