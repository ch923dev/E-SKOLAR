<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Models\College;
use App\Models\Program;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\ProgramResource\RelationManagers;
use Filament\Tables\Filters\SelectFilter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\NumberFilter;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;
    protected static ?string $modelLabel = 'Program';
    protected static ?string $navigationGroup = 'Curriculum Management';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'fas-book-open-reader';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('abbre')
                    ->required(),
                Forms\Components\Select::make('college_id')
                    ->relationship('college', 'name')
            ]);
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
                    ->formatStateUsing(fn ($state) => Str::upper($state))
                    ->toggleable()
                    ->label('Abbreviation'),
                Tables\Columns\TextColumn::make('college.name')
                    ->tooltip(fn (Model $record) => $record->college->name)
                    ->toggleable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('scholars_count')
                    ->counts('scholars')
                    ->toggleable()
                    ->label('Total Scholars'),
            ])
            ->filters([
                SelectFilter::make('college')
                    ->multiple()
                    ->relationship('college', 'name'),
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\ScholarsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'view' => Pages\ViewProgram::route('/{record}'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
