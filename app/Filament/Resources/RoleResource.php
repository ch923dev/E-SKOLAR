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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Filament\Notifications\Notification;

class RoleResource extends Resource
{
    use Permits;
    protected static ?string $model = Role::class;
    protected static ?string $modelLabel = 'Role';
    protected static ?string $navigationGroup = 'Users Management';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-key';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('role')
                    ->unique(table: Role::class, column: 'role')
                    ->label('Role Name')
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
                    ->sortable()
                    ->counts('users')
                    ->label('Total Users'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->before(function (Model $record) {
                            User::where('role_id', $record->id)->update(['role_id' => null]);
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->action(function (Collection $records) {
                        foreach ($records as $value) {
                            $notif = !$value->default ? $records->find($value->id)->delete() : true;
                            if ($notif==true) {
                                Notification::make()
                                    ->title('You cannot delete default roles')
                                    ->icon('heroicon-o-lock-closed')
                                    ->iconColor('danger')
                                    ->send();
                            }
                        }
                    })
            ]);
    }

    public static function getRelations(): array
    {
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
