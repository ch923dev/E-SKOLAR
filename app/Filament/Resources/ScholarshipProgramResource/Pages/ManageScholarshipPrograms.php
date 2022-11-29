<?php

namespace App\Filament\Resources\ScholarshipProgramResource\Pages;

use App\Filament\Resources\ScholarshipProgramResource;
use App\Models\ScholarshipProgram;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageScholarshipPrograms extends ManageRecords
{
    protected static string $resource = ScholarshipProgramResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->form([
                    TextInput::make('name')
                        ->unique(ScholarshipProgram::class,'name')
                        ->required(),
                    Select::make('sponsor_id')
                        ->relationship('sponsor', 'sponsor')
                        ->required(),
                ])
                ->disableCreateAnother(),
        ];
    }
}
