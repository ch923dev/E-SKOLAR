<?php

namespace App\Filament\Resources\ScholarshipOrganizationResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
class ScholarsRelationManager extends RelationManager
{
    protected static string $relationship = 'scholars';

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
                TextColumn::make('user.name')
                    ->toggleable()
                    ->searchable()
                    ->label('Name'),
                TextColumn::make('baranggay.name')
                    ->toggleable()
                    ->label('Baranggay'),
                BadgeColumn::make('status')
                    ->toggleable()
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
                    ]),
                TextColumn::make('scholarship_program.name')
                    ->toggleable()
                    ->sortable()
                    ->label('Scholarship Program'),
                TextColumn::make('program.abbre')
                    ->toggleable()
                    ->formatStateUsing(fn ($state) => Str::upper($state))
                    ->label('Course'),
                TextColumn::make('college.abbre')
                    ->toggleable()
                    ->label('College'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
