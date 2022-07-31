<?php

namespace App\Filament\Resources\ScholarResource\Pages;

use App\Filament\Resources\ScholarResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListScholars extends ListRecords
{
    protected static string $resource = ScholarResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
