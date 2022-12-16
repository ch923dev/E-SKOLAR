<?php

namespace App\Filament\Resources\ScholarResource\Pages;

use App\Filament\Resources\ScholarResource;
use App\Models\Role;
use App\Models\Scholar;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Hash;
use Ysfkaya\FilamentPhoneInput\PhoneInput;

class ManageScholars extends ManageRecords
{
    protected static string $resource = ScholarResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->using(function ($data) {
                    $user = User::create([
                        'avatar_url' => 'pngtree-blue-default-avatar-png-image_2813123.jpg',
                        'email' => $data['email'],
                        'name' => $data['fname'] . ' ' . $data['lname'],
                        'role_id' => Role::where('role', 'Scholar')->first()->id,
                        'password' => Hash::make(Carbon::now()->year . '-' . $data['lname']),
                    ]);

                    $scholar = Scholar::create([
                        'fname' => $data['fname'],
                        'lname' => $data['lname'],
                        'status' => 3,
                        'user_id' => $user->id,
                        'baranggay_id' => $data['baranggay_id'],
                        'program_id' => $data['program_id'],
                        'scholarship_program_id' => $data['scholarship_program_id'],
                    ]);
                    return $scholar;
                })
                ->steps([
                    Step::make('Scholar Information')
                        ->schema([
                            Section::make('Personal Details')
                                ->schema([
                                    Group::make([
                                        TextInput::make('fname')
                                            ->label('First Name')
                                            ->required(),
                                        TextInput::make('lname')
                                            ->label('Last Name')
                                            ->required(),
                                        TextInput::make('email')
                                            ->label('Email')
                                            ->email()
                                            ->required(),
                                        PhoneInput::make('contact_number')
                                            ->required()
                                            ->initialCountry('ph')
                                            ->disallowDropdown()
                                            ->separateDialCode(true)
                                    ])->columns(2),
                                    Select::make('baranggay_id')
                                        ->relationship('baranggay', 'name')
                                        ->required()
                                        ->label('Baranggay'),
                                ]),

                        ]),
                    Step::make('Curriculum Details')
                        ->schema([
                            Section::make('Curriculum Details')
                                ->schema([
                                    Select::make('program_id')
                                        ->relationship('program', 'name')
                                        ->required()
                                ]),
                        ]),
                    Step::make('Scholarship Program')
                        ->schema([
                            Section::make('Scholarship Program')
                                ->schema([
                                    Select::make('scholarship_program_id')
                                        ->relationship('scholarship_program', 'name')
                                        ->label('Scholarship Program')
                                        ->required()
                                ])
                        ])
                ]),

        ];
    }
}
