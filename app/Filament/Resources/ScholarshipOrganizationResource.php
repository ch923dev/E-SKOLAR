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
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScholarshipOrganizationResource extends Resource
{
    protected static ?string $model = ScholarshipOrganization::class;

    protected static ?string $modelLabel = "Scholarship Organization";
    protected static ?string $navigationIcon = 'fas-sitemap';
    protected static ?string $navigationGroup = 'Scholarships Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label('Name'),
                TextColumn::make('abbre')
                    ->label('Abbreviation'),
                TextColumn::make('scholarship_programs_count')
                    ->sortable()
                    ->counts('scholarship_programs')
                    ->label('Total Scholarship Programs'),
                TextColumn::make('scholars_count')
                    ->sortable()
                    ->counts('scholars')
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
            'index' => Pages\ManageScholarshipOrganizations::route('/'),
            'view' => Pages\ViewScholarshipOrganization::route('/{record}'),
        ];
    }
}
