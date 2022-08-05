<?php

namespace App\Filament\Resources\ScholarResource\Pages;

use App\Filament\Resources\ScholarResource;
use App\Models\User;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateScholar extends CreateRecord
{
    protected static string $resource = ScholarResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // $data['user']['name'] =  $data['fname'] . ' ' . $data['mname'][0] . '. ' . $data['lname'];
        // $data['user']['password'] =  Hash::make($data['id'] . $data['lname']);
        // $data['user']['role_id'] =  3;
        // $data['user_id'] = User::firstOrCreate($data['user'])->id;
        // dd($data);
        return $data;
    }
}
