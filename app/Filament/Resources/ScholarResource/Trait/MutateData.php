<?php

namespace App\Filament\Resources\ScholarResource\Trait;

use App\Models\User;

trait MutateData
{
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // dd($data['user_id']);
        $user = User::find($data['user_id']);
        $data['user']['email'] = $user->email;
        $data['user']['contact_number'] = $user->contact_number ? $user->contact_number : 'No Contact Number';
        $data['user']['avatar_url'] = $user->avatar_url;
        return $data;
    }
}
