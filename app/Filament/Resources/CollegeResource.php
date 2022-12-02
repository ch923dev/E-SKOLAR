<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CollegeResource\Pages;
use App\Filament\Resources\CollegeResource\RelationManagers;
use App\Models\College;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CollegeResource extends Resource
{
    protected static ?string $model = College::class;
    protected static ?string $navigationGroup = 'Curriculum Management';

    protected static ?string $navigationIcon = 'fas-building-columns';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->tooltip(fn (Model $record) => $record->name)
                    ->searchable()
                    ->toggleable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('abbre')
                    ->searchable()
                    ->formatStateUsing(fn ($state) => strtoupper($state))
                    ->toggleable()
                    ->label('Abbreviation'),
                Tables\Columns\TextColumn::make('programs_count')
                    ->counts('programs')
                    ->toggleable()
                    ->label('Total Programs'),
                Tables\Columns\TextColumn::make('scholars_count')
                    ->counts('scholars')
                    ->toggleable()
                    ->label('Total Scholars'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageColleges::route('/'),
        ];
    }
}
