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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\MultiSelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\ProgramResource\RelationManagers;

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
                    ->formatStateUsing(fn ($state) => strtoupper($state))
                    ->toggleable()
                    ->label('Abbreviation'),
                Tables\Columns\TextColumn::make('college.name')
                    ->tooltip(fn (Model $record) => College::find($record->college_id)->name)
                    ->toggleable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('scholars_count')
                    ->counts('scholars')
                    ->toggleable()
                    ->label('Scholars'),
            ])
            ->filters([
                MultiSelectFilter::make('college')
                    ->relationship('college', 'name'),
                Filter::make('scholars_count')
                    ->form([
                        TextInput::make('more_than_count')
                            ->numeric()
                            ->label('Scholars count more than'),
                        TextInput::make('less_than_count')
                            ->numeric()
                            ->label('Scholars count less than'),

                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['less_than_count'], function (Builder $query, $count) {
                                return $query->has('scholars', '<', $count);
                            })
                            ->when($data['more_than_count'], function (Builder $query, $count) {
                                return $query->has('scholars', '>', $count);
                            });;
                    })

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
