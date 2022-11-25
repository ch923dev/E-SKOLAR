<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Imports\UsersImport;
use App\Models\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Filters\MultiSelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Phpsa\FilamentPasswordReveal\Password;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $modelLabel = 'User';
    protected static ?string $pluralModelLabel = 'Users';
    protected static ?string $navigationGroup = 'Users Management';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                []
            );
    }
    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([])
            ->columns([
                ImageColumn::make('avatar_url')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role.role')
                    ->label('Role'),
                Tables\Columns\TextColumn::make('contact_number')
                    ->formatStateUsing(function ($state) {
                        return $state ?? 'No Contact Number';
                    })
                    ->label('Contact Number'),
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->multiple()
                    ->options(
                        Role::whereNot('role', '=', 'Scholar')
                            ->whereNot('role', '=', 'Organization')
                            ->pluck('role', 'id')
                    )
                    ->attribute('role.role')
                    ->label('Role')
            ])
            ->actions([

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
            ]);
    }
    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::whereNot('role_id', Role::where('role', 'Scholar')->pluck('id','id'))
            ->whereNot('role_id', Role::where('role', 'Organization')->pluck('id', 'id'));
    }
    public static function getRelations(): array
    {
        return [
            RelationManagers\PermissionsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUser::route('/'),
            // 'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
