<?php

namespace App\Filament\Resources\RoleResource\RelationManagers;

use App\Filament\Actions\ChangeAccessLevel;
use App\Models\Module;
use App\Models\ModuleRole;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;

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
                Tables\Columns\BadgeColumn::make('level')
                    ->enum([
                        '0'=>'Not Applicable',
                        '1'=>'View',
                        '2'=>'Manage',
                    ])
                    ->colors([
                        'primary',
                        'danger' => static fn ($state): bool => $state == '0',
                        'warning' => static fn ($state): bool => $state == '1',
                        'success' => static fn ($state): bool => $state == '2',
                    ])
                    ->label('Access Level'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('change_access_level')
                    ->mountUsing(fn (ComponentContainer $form, Model $record) => $form->fill([
                        'level' => $record->pivot->level
                    ]))
                    ->action(function (Model $record, array $data, $livewire) {
                        $relationship = $livewire->getRelationship();
                        if ($relationship instanceof BelongsToMany) {
                            $pivotColumns = $relationship->getPivotColumns();
                            $pivotData = Arr::only($data, $pivotColumns);
                            if (count($pivotColumns)) {
                                $record->{$relationship->getPivotAccessor()}->update($pivotData);
                            }
                        }
                    })
                    ->form([
                        Select::make('level')
                            ->options([
                                '0' => 'Not Applicable',
                                '1' => 'View',
                                '2' => 'Manage'
                            ])
                            ->required()
                            ->label('Access Level')
                    ])
                    ->modalButton('Save')
            ])
            ->bulkActions([]);
    }
}
