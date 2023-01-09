<?php

namespace App\Filament\Resources\ScholarshipOrganizationResource\Pages;

use App\Filament\Resources\ScholarshipOrganizationResource;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageScholarshipOrganizations extends ManageRecords
{
    protected static string $resource = ScholarshipOrganizationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->steps([
                    Step::make('Scholarship Organization')
                        ->schema([
                            TextInput::make('name')
                                ->label('Name')
                                ->required(),
                            TextInput::make('abbre')
                                ->unique()
                                ->unique()
                                ->label('Abbreviation')
                                ->required(),
                        ]),
                    Step::make('Scholarship Program')
                        ->schema([
                            CheckboxList::make('scholarship_programs')
                                ->label('Scholarship Program')
                                ->bulkToggleable()
                                ->relationship('scholarship_programs', 'name')
                        ])
                ])
        ];
    }
}
