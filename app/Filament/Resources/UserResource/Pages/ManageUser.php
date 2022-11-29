<?php

namespace App\Filament\Resources\UserResource\Pages;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;
use Ysfkaya\FilamentPhoneInput\PhoneInput;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;

class ManageUser extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getTableHeaderActions(): array
    {
        return [
            FilamentExportHeaderAction::make('export')->button()
        ];
    }
    protected function getActions(): array
    {
        return [
            ImportAction::make()
                ->uniqueField('email')
                ->mutateBeforeCreate(function ($data) {
                    $data['password'] = Hash::make(Str::random(8));
                    return $data;
                })
                ->fields([
                    ImportField::make('name')
                        ->label('Name')
                        ->required(),
                    ImportField::make('email')
                        ->label('Email')
                        ->required(),
                    ImportField::make('role_id')
                        ->mutateBeforeCreate(fn ($string) => Role::where('role', $string)->first()->id)
                        ->label('Role')
                        ->required(),
                    ImportField::make('contact_number')
                        ->label('Contact Number')
                        ->required(),
                ]),
            Actions\CreateAction::make()
                ->disableCreateAnother()
                ->mutateFormDataUsing(function (array $data) {
                    $data['password'] = Hash::make(Str::random(8));
                    return $data;
                })
                ->form([
                    Group::make([
                        Card::make([
                            TextInput::make('name')
                                ->required(),
                            TextInput::make('email')
                                ->unique(User::class, 'email')
                                ->email()
                                ->required(),
                            Select::make('role_id')
                                ->options(Role::whereNot('role', 'Organization')->whereNot('role', 'Scholar')->pluck('role', 'id'))
                                ->label('Role')
                                ->required(),
                            PhoneInput::make('contact_number')
                                ->initialCountry('ph')
                                ->disallowDropdown()
                                ->separateDialCode(true),
                        ])->columns(2)->columnSpan(3),
                        Card::make([
                            Placeholder::make('Avatar'),
                            FileUpload::make('avatar_url')
                                ->avatar()
                                ->label('Avatar')
                        ])->columnSpan(1),
                    ])->columns(4)
                ]),
        ];
    }
}
