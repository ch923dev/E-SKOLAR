<?php

namespace App\Filament\Resources\ScholarResource\Pages;

use App\Filament\Resources\ScholarResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateScholar extends CreateRecord
{
    protected static string $resource = ScholarResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
