<?php

namespace App\Filament\Resources\ProgramResource\RelationManagers;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScholarsRelationManager extends RelationManager
{
    protected static string $relationship = 'scholars';
    protected static ?string $modelLabel = 'Scholar';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                Forms\Components\Group::make([
                    Forms\Components\Group::make([
                        Forms\Components\TextInput::make('fname')
                            ->label('First Name')
                            ->required(),
                        Forms\Components\TextInput::make('mname')
                            ->label('Middle Name')
                            ->required(),
                        Forms\Components\TextInput::make('lname')
                            ->label('Last Name')
                            ->required(),
                    ])->columns(3),
                    Forms\Components\TextInput::make('id')
                        ->label('ID')
                        ->required(),

                    Forms\Components\TextInput::make('user.email')
                        ->email()
                        ->unique(User::class, 'email', fn ($record) => $record)
                        ->label('Email')
                        ->required(),
                    Forms\Components\TextInput::make('user.contact_number')
                        ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask->pattern('+{639} 000 000 000'))
                        ->label('Contact Number'),
                    Forms\Components\Select::make('year_id')
                        ->relationship('year', 'year')
                        ->required(),
                    Forms\Components\Select::make('sponsor_id')
                        ->relationship('sponsor', 'name')
                        ->required(),
                    Forms\Components\Select::make('scholar_status_id')
                        ->relationship('scholar_status', 'status')
                        ->required(),
                    Forms\Components\Select::make('last_allowance_receive')
                        ->relationship('allowance_receive', 'year')
                        ->required()
                ])
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Name'),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('year.year')
                    ->label('Year Level'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                // FilamentExportHeaderAction::make('export')
                //     ->disablePreview()
                //     ->disableAdditionalColumns()
                //     ->button(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
