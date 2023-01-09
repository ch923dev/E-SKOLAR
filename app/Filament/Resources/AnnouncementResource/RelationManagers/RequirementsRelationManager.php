<?php

namespace App\Filament\Resources\AnnouncementResource\RelationManagers;

use App\Models\Requirement;
use App\Models\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequirementsRelationManager extends RelationManager
{
    protected static string $relationship = 'requirements';

    protected static ?string $recordTitleAttribute = 'description';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TagsColumn::make('filetypes'),
                Tables\Columns\TextColumn::make('users_count')
                    ->visible(function () {
                        return auth()->user()->role_id === Role::where('role', 'Admin')->first()->id;
                    })
                    ->counts('users'),
                Tables\Columns\TextColumn::make('status')
                    ->visible(auth()->user()->role_id === Role::where('role', 'Scholar')->first()->id)
                    ->formatStateUsing(function ($record) {
                        $state = $record->users()->where('user_id', auth()->id())->first()->pivot->status ?? 'No submission';
                        return Str::title($state);
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('submit')
                    ->action(fn ($livewire) => dd($livewire->ownerRecord->requirements))
                    ->form([
                        TextInput::make('hello')
                    ]),
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('submit')
                    ->action(function ($data, $record) {
                        $user = User::find(auth()->user()->id)->requirements()->updateExistingPivot($record->id, [
                            'status' => 'submitted',
                            'document' => $data['document']
                        ]);
                    })
                    ->mountUsing(fn ($form, $record) => $form->fill([
                        'description' => $record->description
                    ]))
                    ->form([
                        TextInput::make('description')
                            ->disabled(),
                        FileUpload::make('document')
                            ->acceptedFileTypes(fn ($record) => $record->filetypes)
                            ->preserveFilenames()
                    ]),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
