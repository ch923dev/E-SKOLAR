<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SponsorCategoryResource\Pages;
use App\Filament\Resources\SponsorCategoryResource\RelationManagers;
use App\Models\SponsorCategory;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SponsorCategoryResource extends Resource
{
    protected static ?string $model = SponsorCategory::class;
    protected static ?string $modelLabel = 'Sponsor Category';
    protected static ?string $navigationGroup = 'Sponsors Management';
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?int $navigationSort = 2;
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
                Tables\Columns\TextColumn::make('sponsors_count')
                    ->counts('sponsors')
                    ->label('Total Sponsors'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                ])
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {

        $relations = [];
        // if (auth()->user()->permissions->where('name', 'View Sponsors')->first() ? true : false)
        //     $relations[] = RelationManagers\SponsorsRelationManager::class;

        return $relations;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSponsorCategories::route('/'),
            'create' => Pages\CreateSponsorCategory::route('/create'),
            'view' => Pages\ViewSponsorCategory::route('/{record}'),
            'edit' => Pages\EditSponsorCategory::route('/{record}/edit'),
        ];
    }
}
