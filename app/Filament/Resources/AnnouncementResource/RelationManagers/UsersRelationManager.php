<?php

namespace App\Filament\Resources\AnnouncementResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'recipients';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('scholar.lname')
                    ->label('Last Name')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('scholar.fname')
                    ->label('First Name')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('baranggay.name')
                    ->label('Barangay')
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('program.abbre')
                    ->tooltip(fn ($record) => $record->program->name)
                    ->formatStateUsing(fn ($state) => Str::upper($state))
                    ->label('Course')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('college.abbre')
                    ->tooltip(fn ($record) => $record->college->name)
                    ->formatStateUsing(fn ($state) => Str::upper($state))
                    ->label('College')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('scholarship_program.name')
                    ->sortable()
                    ->label('Scholarship Program')
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('scholar.status')
                    ->label('Status')
                    ->sortable()
                    ->enum([
                        '1' => 'Pending',
                        '2' => 'Inactive',
                        '3' => 'Active',
                        '4' => 'Graduate',
                    ])
                    ->colors([
                        'primary',
                        'warning' => static fn ($state): bool => $state == '1',
                        'danger' => static fn ($state): bool => $state == '2',
                        'success' => static fn ($state): bool => $state == '3',
                        'success' => static fn ($state): bool => $state == '4',
                    ])
                    ->toggleable(),


            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([])
            ->bulkActions([]);
    }
}
