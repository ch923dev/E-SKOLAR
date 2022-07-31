<?php

namespace App\Filament\Resources\ScholarResource\Pages;

use App\Filament\Resources\ScholarResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditScholar extends EditRecord
{
    protected static string $resource = ScholarResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
