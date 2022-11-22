<?php

namespace App\Filament\Resources\ModuleResource\Pages;

use App\Filament\Resources\ModuleResource;
use App\Models\Module;
use App\Models\Role;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Closure;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ManageModules extends ManageRecords
{
    protected static string $resource = ModuleResource::class;
    protected static bool $canCreateAnother = false;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->using(function ($data) {
                    $list_roles = $data['roles'];
                    foreach ($list_roles as $value)
                        $roles[$value['role_id']] = ['level' => $value['level']];
                    $module = Module::create($data);
                    $module->roles()->attach($roles);
                    return $module;
                })
                ->steps([
                    Step::make('Module')
                        ->description('Give the module a clear and unique name')
                        ->schema([
                            TextInput::make('module')
                                ->afterStateUpdated(fn ($state, callable $set) => $set('role', Str::plural($state)))
                                ->unique(table: Module::class, column: 'module')
                                ->required()
                        ]),
                    Step::make('Roles')
                        ->description('Give Access Level to each Role')
                        ->schema([
                            Repeater::make('roles')->label('List of roles')
                                ->afterStateHydrated(function (Repeater $component, $state) {
                                    $items = [];
                                    foreach (Role::all() as $value) {
                                        $items[(string) Str::uuid()] = [
                                            'role_id' => $value->id, 'level' => $value->role == 'Admin' ? 2 : $state[$value->id]['level'] ?? null, 'role' => $value->role
                                        ];
                                    }
                                    $component->state($items);
                                })
                                ->schema([
                                    Select::make('role_id')
                                        ->options(Role::all()->pluck('role', 'id'))
                                        ->disabled()
                                        ->label('Role Name'),
                                    Select::make('level')->label('Access Level')
                                        ->disabled(fn (callable $get) => $get('role') == 'Admin')
                                        ->required()
                                        ->options([
                                            '0' => 'Not Applicable',
                                            '1' => 'View',
                                            '2' => 'Manage'
                                        ])
                                ])
                                ->disableItemCreation()->disableItemDeletion()
                        ]),
                ]),
        ];
    }
    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (Model $record): string => static::$resource::getUrl('view', ['record' => $record]);
    }
}
