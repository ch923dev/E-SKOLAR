<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Filament\Trait\Permits;
use App\Models\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;

class RoleResource extends Resource
{
    use Permits;
    protected static ?string $model = Role::class;
    protected static ?string $modelLabel = 'Role';
    protected static ?string $navigationGroup = 'Users Management';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('role')
                    ->unique(table: Role::class, column: 'role')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('role')
                    ->searchable(),
                Tables\Columns\TextColumn::make('users_count')
                    ->counts('users')
                    ->label('Total Users'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()->hidden(fn (Model $record) => match ($record->role) {
                        'Admin' => true,
                        'Staff' => true,
                        'Scholar' => true,
                        'Organization' => true,
                        default => false
                    }),
                    Tables\Actions\DeleteAction::make()->hidden(fn (Model $record) => match ($record->role) {
                        'Admin' => true,
                        'Staff' => true,
                        'Scholar' => true,
                        'Organization' => true,
                        default => false
                    })->before(function (Model $record) {
                        User::where('role_id', $record->id)->update(['role_id' => null]);
                    }),

                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->disabled(function (Collection $records, DeleteBulkAction $action) {
                    if ($records->whereIn('role', ['Organization', 'Admin', 'Scholar', 'Staff'])->count() >= 1) {
                        return true;
                    } else {
                        Notification::make()
                            ->title('You cannot delete default roles')
                            ->icon('heroicon-o-document-text')
                            ->iconColor('danger')
                            ->send();
                        return false;
                    }
                }),
            ]);
    }

    public static function getRelations(): array
    {
        // $relations = [];
        // if (auth()->user()->permissions->where('name', 'View Permissions')->first() ? true : false)
        //     $relations[] = RelationManagers\PermissionsRelationManager::class;
        // if (auth()->user()->permissions->where('name', 'View Users')->first() ? true : false)
        //     $relations[] = RelationManagers\UsersRelationManager::class;
        // return $relations;
        return [
            RelationManagers\ModulesRelationManager::class,
            RelationManagers\UsersRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRoles::route('/'),
            'view' => Pages\ViewRole::route('/{record}'),
        ];
    }
}
