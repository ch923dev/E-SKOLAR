<?php

namespace App\Filament\Resources\ScholarResource\Pages;

use App\Filament\Resources\ScholarResource;
use App\Models\User;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class CreateScholar extends CreateRecord
{
    protected static string $resource = ScholarResource::class;
    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user']['name'] = $data['fname'] . ' ' . $data['mname'][0] . '. ' . $data['lname'];
        $data['user']['password'] = Str::slug($data['user']['name']);
        $data['user']['role_id'] = 3;
        $user_data = [
            'name' => $data['user']['name'],
            'password' => $data['user']['password'],
            'role_id' => $data['user']['role_id'],
        ];
        $user_data = $data['user']['avatar_url'] ? array_merge($user_data, ['avatar_url' => $data['user']['contact_number']]) : $user_data;
        $user_data = $data['user']['contact_number'] ? array_merge($user_data, ['contact_number' => $data['user']['contact_number']]) : $user_data;
        $data['user_id'] = User::firstOrCreate(
            [
                'email' => $data['user']['email']
            ],$user_data
        )->id;
        return $data;
    }
}
