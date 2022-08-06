<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Trait\Permits;
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
use Filament\Tables\Filters\MultiSelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Phpsa\FilamentPasswordReveal\Password;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;


class UserResource extends Resource
{
    use Permits;
    protected static ?string $model = User::class;
    protected static ?string $modelLabel = 'User';
    protected static ?string $pluralModelLabel = 'Users';
    protected static ?string $navigationGroup = 'Users Management';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getFormSchema());
    }
    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                FilamentExportHeaderAction::make('export')
                    ->disablePreview()
                    ->disableAdditionalColumns()
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
                Tables\Columns\TextColumn::make('contact_number')
                    ->formatStateUsing(function ($state) {
                        return $state ? $state : 'No Contact Number';
                    })
                    ->label('Contact Number'),
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
                Tables\Actions\ViewAction::make()
                    ->visible(static::can_view(static::$pluralModelLabel)),
                Tables\Actions\EditAction::make()
                    ->visible(static::can_manage(static::$pluralModelLabel)),
                Tables\Actions\DeleteAction::make()
                    ->visible(static::can_manage(static::$pluralModelLabel)),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(static::can_manage(static::$pluralModelLabel)),
            ]);
    }

    public static function getFormSchema()
    {
        return
            Group::make([
                Card::make([
                    Forms\Components\TextInput::make('name')
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->unique(User::class, 'email', fn ($record) => $record)
                        ->email()
                        ->required(),
                    Forms\Components\Select::make('role_id')
                        ->options(Role::whereNot('name', 'Organization')->whereNot('name', 'Scholar')->pluck('name', 'id'))
                        ->label('Role')
                        ->required(),
                    Forms\Components\TextInput::make('contact_number')
                        ->mask(fn (TextInput\Mask $mask) => $mask->pattern('+{639} 000 000 000'))
                ])->columns(2)->columnSpan(3),
                Card::make([
                    Placeholder::make('Avatar'),
                    FileUpload::make('avatar_url')
                        ->avatar()
                        ->label('Avatar')
                ])->columnSpan(1),
            ])->columns(4);
    }
    public static function getEloquentQuery(): Builder
    {
        // dd(Role::where('name', 'Scholar')->first()->id);
        return static::getModel()::query()
            ->whereNot('id', '=', auth()->user()->id)
            ->whereNot(
                'role_id',
                Role::where('name', 'Scholar')->first()->id,
            )
            ->whereNot(
                'role_id',
                Role::where('name', 'Organization')->first()->id
            );
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
