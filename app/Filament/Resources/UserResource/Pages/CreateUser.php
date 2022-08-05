<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Mail\UserCreatedCredentials;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class CreateUser extends CreateRecord
{
    protected static bool $canCreateAnother = false;

    protected static string $resource = UserResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = Hash::make($data['password']);
        // Mail::to($data['email'])->send(new UserCreatedCredentials());

        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
    protected function getCreatedNotificationMessage(): ?string
    {
        return 'New User Added';
    }
}
