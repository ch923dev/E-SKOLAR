<?php

namespace App\Filament\Resources\ScholarshipOrganizationResource\Pages;

use App\Filament\Resources\ScholarshipOrganizationResource;
use App\Models\User;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Hash;
use Ysfkaya\FilamentPhoneInput\PhoneInput;

class ManageScholarshipOrganizations extends ManageRecords
{
    protected static string $resource = ScholarshipOrganizationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function ($data) {
                    $data['user_id'] = User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'password' => Hash::make($data['name']),
                        'role_id' => 5,
                        'contact_number' => $data['contact_number'] ?? fake('en_PH')->mobileNumber(),
                        'avatar_url' => $data['avatar_url'] ?? 'pngtree-blue-default-avatar-png-image_2813123.jpg'
                    ])->id;
                    return $data;
                })
                ->steps([
                    Step::make('Scholarship Organization')
                        ->schema(
                            [
                                Group::make([
                                    Card::make([
                                        TextInput::make('name')
                                            ->label('Name')
                                            ->required(),
                                        TextInput::make('abbre')
                                            ->unique()
                                            ->unique()
                                            ->label('Abbreviation')
                                            ->required(),
                                        TextInput::make('email')
                                            ->required()
                                            ->unique(User::class, 'email')
                                            ->email(),
                                        PhoneInput::make('contact_number')
                                            ->initialCountry('ph')
                                            ->disallowDropdown()
                                            ->separateDialCode(true),
                                    ])->columns(2)->columnSpan(2),
                                    Card::make([
                                        Placeholder::make('Avatar'),
                                        FileUpload::make('avatar_url')
                                            ->avatar()
                                            ->label('Avatar')
                                    ])->columnSpan(1),
                                ])->columns(3)
                            ]
                        ),
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
