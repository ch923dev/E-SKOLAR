<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Imports\UsersImport;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\UserType;
use Carbon\Carbon;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Section;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\MultiSelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Phpsa\FilamentPasswordReveal\Password;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static bool $shouldRegisterNavigation = true;
    protected static ?string $modelLabel = 'User';
    protected static ?string $navigationGroup = 'Users Management';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-s-user-group';

    public static function form(Form $form): Form
    {
        // dd(auth()->user()->permission->first());
        return $form
            ->schema(static::getFormSchema());
    }
    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                FilamentExportHeaderAction::make('export')
                    ->button(),
                Action::make('import')
                    ->action(function (array $data) {
                        $import = new UsersImport();
                        $import->import('storage/' . $data['file']);
                        Notification::make()
                            ->title('Successfully Imported')
                            ->success()
                            ->send();
                        if (count($import->failures()) > 0)
                            Notification::make()
                                ->title(count($import->failures()) . ' failed to be imported')
                                ->danger()
                                ->send();
                    })
                    ->form([
                        Forms\Components\FileUpload::make('file')
                            ->required()
                    ])
                    ->hidden(function () {
                        return auth()->user()->permissions->where('name', 'Manage Users')->first() ? false : true;
                    })
                    ->button()
                    ->icon('heroicon-o-upload')
            ])
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role.name')->label('Role'),
            ])
            ->filters([
                MultiSelectFilter::make('roles')
                    ->options(Role::whereNot('name', '=', 'Scholar')
                        ->whereNot('name', '=', 'Organization')
                        ->pluck('name', 'id'))
                    ->column('role.name')
                    ->label('Role')
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getFormSchema()
    {
        return
            Group::make([
                Group::make([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->unique(User::class, 'email', fn ($record) => $record)
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Password::make('password')
                        ->passwordLength(8)
                        ->passwordUsesNumbers()
                        ->hidden(fn (?User $record): bool => $record ? true  : false)
                        ->required()
                ]),
                Group::make([
                    Forms\Components\Select::make('role_id')
                        ->options(Role::whereNot('name', 'Organization')->whereNot('name', 'Scholar')->pluck('name', 'id'))
                        ->label('Type')
                        ->reactive()
                        ->required(),
                ]),
            ])->columns(2);
    }
    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->whereNot('id', '=', auth()->user()->id)->whereNot('name', '');
    }
    public static function getRelations(): array
    {
        $relations = [];
        if (auth()->user()->permissions->where('name', 'View Permissions')->first() ? true : false)
            $relations[] = RelationManagers\PermissionsRelationManager::class;

        return $relations;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
