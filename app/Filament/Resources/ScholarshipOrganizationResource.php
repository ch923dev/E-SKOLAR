<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScholarshipOrganizationResource\Pages;
use App\Filament\Resources\ScholarshipOrganizationResource\RelationManagers;
use App\Models\ScholarshipOrganization;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScholarshipOrganizationResource extends Resource
{
    protected static ?string $model = ScholarshipOrganization::class;

    protected static ?string $modelLabel = "Scholarship Organization";
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->unique(column: 'name')
                    ->required(),
                TextInput::make('abbre')
                    ->unique(column: 'abbre')
                    ->required(),
                Select::make('scholarship_program')
                    ->multiple()
                    ->label('Scholarship Program')
                    ->relationship('scholarship_program', 'name')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([])
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
            'index' => Pages\ManageScholarshipOrganizations::route('/'),
        ];
    }
}
