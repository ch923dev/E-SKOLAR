<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use App\Models\Module;
use App\Models\Role;
use App\Models\User;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Closure;
use Filament\Forms\Components\Wizard\Step;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Illuminate\Support\Str;

class ManageRoles extends ManageRecords
{
    protected static string $resource = RoleResource::class;
    protected static bool $canCreateAnother = false;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->using(function ($data) {
                    $list_users = $data['users'];
                    $list_modules = $data['modules'];
                    $modules = [];
                    $users = [];
                    foreach ($list_modules as $value) {
                        $modules[$value['module_id']] = ['level' => $value['level']];
                    }
                    foreach ($list_users as $value) {
                        $users[] = User::find($value['user_id']);
                    }
                    $role = Role::create($data);
                    $role->modules()->attach($modules);
                    $role->users()->saveMany($users);
                    return $role;
                })
                ->steps([
                    Step::make('Role')
                        ->description('Give the role a clear and unique name')
                        ->schema([
                            Forms\Components\TextInput::make('role')
                                ->unique(table: Role::class, column: 'role')
                                ->required()
                        ]),
                    Step::make('Modules')
                        ->description('Give Access Level to each Module')
                        ->schema([
                            Repeater::make('modules')->label('List of Modules')
                                ->afterStateHydrated(function (Repeater $component, $state) {
                                    $items = [];
                                    foreach (Module::all() as $value) {
                                        $items[(string) Str::uuid()] = ['module_id' => $value->id, 'level' => $state[$value->id]['level'] ?? null];
                                    }
                                    $component->state($items);
                                })
                                ->schema([
                                    Forms\Components\Select::make('module_id')
                                        ->options(Module::all()->pluck('module', 'id'))
                                        ->disabled()
                                        ->label('Module Name'),
                                    Forms\Components\Select::make('level')->label('Access Level')
                                        ->required()
                                        ->options([
                                            '0' => 'Not Applicable',
                                            '1' => 'View',
                                            '2' => 'Manage'
                                        ])
                                ])->disableItemCreation()->disableItemDeletion()
                        ]),
                    Step::make('Users')
                        ->description('Attaching Users to role')
                        ->schema([
                            Repeater::make('users')
                                ->label('List of Users')
                                ->schema([
                                    Forms\Components\Select::make('user_id')
                                        ->options(User::whereNull('role_id')->pluck('name', 'id'))
                                        ->label('User\'s Name'),
                                ])
                        ])
                ]),
        ];
    }
    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (Model $record): string => static::$resource::getUrl('view', ['record' => $record]);
    }
}
