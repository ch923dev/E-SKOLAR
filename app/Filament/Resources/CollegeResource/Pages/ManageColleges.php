<?php

namespace App\Filament\Resources\CollegeResource\Pages;

use App\Filament\Resources\CollegeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageColleges extends ManageRecords
{
    protected static string $resource = CollegeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
