<?php

namespace App\Filament\Resources\ModuleResource\Pages;

use App\Filament\Resources\ModuleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewModule extends ViewRecord
{
    protected static string $resource = ModuleResource::class;

    protected function getActions(): array
    {
        return [];
    }
}
