<?php

namespace App\Filament\Resources\AcademicResource\Pages;

use App\Filament\Resources\AcademicResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAcademics extends ManageRecords
{
    protected static string $resource = AcademicResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
