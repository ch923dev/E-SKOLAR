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
    // protected static ?string $modelLabel = "User";
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
                            ->hidden(fn (?Model $record): bool => $record ? true  : false),
                        Forms\Components\TextInput::make('email')
                            ->unique(User::class, 'email', fn ($record) => $record)
                            ->email()
                            ->required()
                            ->hidden(fn (?Model $record): bool => $record ? true  : false),
                        Password::make('password')
                            ->passwordLength(8)
                            ->passwordUsesNumbers()
                            ->hidden(fn (?Model $record): bool => $record ? true  : false)
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
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('New User')->disableCreateAnother(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Change Role'),
            ])
            ->bulkActions([
            ]);
    }
}
