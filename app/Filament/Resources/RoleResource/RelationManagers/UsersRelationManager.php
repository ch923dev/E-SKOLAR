<?php

namespace App\Filament\Resources\RoleResource\RelationManagers;

use App\Filament\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Phpsa\FilamentPasswordReveal\Password;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'role';
    public function getTableModelLabel(): string
    {
        return 'User with ' . $this->ownerRecord->role . ' access level.';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                Group::make([
                    Group::make([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->hiddenOn('edit'),
                        Forms\Components\TextInput::make('email')
                            ->unique(User::class, 'email', fn ($record) => $record)
                            ->email()
                            ->required()
                            ->hiddenOn('edit'),
                        Password::make('password')
                            ->passwordLength(8)
                            ->passwordUsesNumbers()
                            ->hiddenOn('edit')
                            ->required(),
                        Forms\Components\Select::make('role_id')
                            ->relationship('role', 'role')
                            ->hiddenOn('create')
                    ]),
                ])->columns(1)
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_number')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('New User')->disableCreateAnother(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Change Role'),
            ]);
    }
}
