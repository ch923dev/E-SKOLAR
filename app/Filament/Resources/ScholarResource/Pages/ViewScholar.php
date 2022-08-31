<?php

namespace App\Filament\Resources\ScholarResource\Pages;

use App\Filament\Resources\ScholarResource;
use App\Filament\Resources\ScholarResource\Trait\MutateData;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewScholar extends ViewRecord
{
    use MutateData;
    protected static string $resource = ScholarResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

}
