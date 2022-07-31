<?php

namespace App\Filament\Resources\SponsorCategoryResource\RelationManagers;

use App\Filament\Trait\Permits;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SponsorsRelationManager extends RelationManager
{
    use Permits;
    protected static string $relationship = 'sponsors';

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
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->visible(static::can_manage(static::$relationship))
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->visible(static::can_view(static::$relationship)),
                Tables\Actions\EditAction::make()
                    ->visible(static::can_manage(static::$relationship)),
                Tables\Actions\DeleteAction::make()
                    ->visible(static::can_manage(static::$relationship)),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(static::can_manage(static::$relationship)),
            ]);
    }
}
