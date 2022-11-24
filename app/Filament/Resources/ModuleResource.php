<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModuleResource\Pages;
use App\Filament\Resources\ModuleResource\RelationManagers;
use App\Models\Module;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

class ModuleResource extends Resource
{
    protected static ?string $model = Module::class;
    protected static ?string $modelLabel = 'Module';
    protected static ?string $navigationGroup = 'Users Management';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('module')
            ]);
    }
    public static function role_user_count(Model $record, $relationship): string
    {
        $total_users = [];
        foreach ($record[$relationship] as $value) {
            $total_users[] = $value->users->count();
        }
        return array_sum($total_users) . ' ( ' . $record[$relationship]->count() . ' )';
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('module')
                    ->searchable()
                    ->label('Module Name'),
                TextColumn::make('roles_manage')
                    ->label('Manage Policy')
                    ->tooltip('Total users and total roles who manage this module')
                    ->getStateUsing(static function (Model $record): string {
                        return static::role_user_count($record, 'roles_manage');
                    }),
                TextColumn::make('roles_view')
                    ->label('View Policy')
                    ->tooltip('Total users and total roles who can only view this module')
                    ->getStateUsing(static function (Model $record): string {
                        return static::role_user_count($record, 'roles_view');
                    }),
                TextColumn::make('roles_not')
                    ->label('Excluded Policy')
                    ->tooltip('Total users and total roles that are not provided with this module')
                    ->getStateUsing(static function (Model $record): string {
                        return static::role_user_count($record, 'roles_not');
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()->hidden(fn (Model $record) => $record->default),
                    Tables\Actions\DeleteAction::make()->hidden(fn (Model $record) => $record->default),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                ->action(function (Collection $records) {
                    $notif = false;
                    foreach ($records as $value) {
                        if (!$value->default) {
                            $records->find($value->id)->delete();
                        } else {
                            $notif = true;
                        }
                        if ($notif) {
                            Notification::make()
                                ->title('You cannot delete default modules')
                                ->icon('heroicon-o-lock-closed')
                                ->iconColor('danger')
                                ->send();
                        }
                    }
                }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RolesRelationManager::class,
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageModules::route('/'),
            'view' => Pages\ViewModule::route('/{record}'),
        ];
    }
}
