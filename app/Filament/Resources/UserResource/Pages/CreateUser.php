<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUser extends CreateRecord
{
    protected static bool $canCreateAnother = false;

    protected static string $resource = UserResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = Hash::make(Str::slug($data['name']));

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
    protected function afterCreate(): void
    {
        $user = $this->record;

        Notification::make()
            ->title('New user')
            ->icon('heroicon-o-shopping-bag')
            ->body("**{$user->name} - {$user->email}.**")
            ->actions([
                Action::make('View')
                    ->url(UserResource::getUrl('edit', ['record' => $user])),
            ])
            ->sendToDatabase(auth()->user());
    }
}
