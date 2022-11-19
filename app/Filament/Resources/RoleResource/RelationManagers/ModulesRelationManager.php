<?php

namespace App\Filament\Resources\RoleResource\RelationManagers;

use App\Models\Module;
use App\Models\ModuleRole;
use App\Models\Role;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ModulesRelationManager extends RelationManager
{
    protected static string $relationship = 'modules';

    protected static ?string $recordTitleAttribute = 'module';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('module')
                    ->hidden(),
                Forms\Components\Select::make('level')
                    ->required()
                    ->options([
                        '0' => 'Not Applicable',
                        '1' => 'View',
                        '2' => 'Manage'
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('module'),
                Tables\Columns\TextColumn::make('level')->enum([
                    '0' => 'Not Applicable',
                    '1' => 'View',
                    '2' => 'Manage'
                ])->label('Access Level'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Change Access Level')
            ])
            ->bulkActions([
            ]);
    }
}
