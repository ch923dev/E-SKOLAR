<?php

namespace App\Filament\Resources\SponsorResource\Pages;

use App\Filament\Resources\SponsorResource;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSponsors extends ManageRecords
{
    protected static string $resource = SponsorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->steps([
                    Step::make('Sponsor')
                        ->schema([
                            TextInput::make('sponsor')
                                ->label('Sponsor Name')
                                ->required(),
                        ]),
                    Step::make('Scholarship Program')
                        ->schema([
                            Repeater::make('scholarship_programs')
                                ->label('Scholarship Programs')
                                ->relationship('scholarship_programs')
                                ->schema([
                                    TextInput::make('name')
                                        ->unique()
                                        ->label('Scholarship Program')
                                        ->required()
                                ])
                        ])
                ])
        ];
    }
}
