<?php

namespace App\Filament\Resources\ScholarResource\Pages;

use App\Filament\Resources\ScholarResource;
use App\Filament\Resources\ScholarResource\Trait\MutateData;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditScholar extends EditRecord
{
    use MutateData;
    protected static string $resource = ScholarResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        dd($record->user);
        $record->user()->update($data['user']);
        $record->update($data);
        return $record;
    }
}
