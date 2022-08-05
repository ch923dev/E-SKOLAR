<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScholarResource\Pages;
use App\Models\Scholar;
use App\Models\Sponsor;
use App\Models\User;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Closure;
use Filament\Forms\Components\Fieldset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Livewire;

class ScholarResource extends Resource
{
    protected static ?string $model = Scholar::class;
    protected static ?string $modelLabel = 'Scholar';
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                Group::make([
                    Section::make('')->schema([
                        TextInput::make('fname')
                            ->afterStateUpdated(function (Closure $get, Closure $set) {
                                $set('user.name', ($get('fname') ? $get('fname') : '') . ' ' . ($get('mname') ? $get('mname')[0] : '') . '. ' . ($get('lname') ? $get('lname') : ''));
                            })
                            ->reactive()
                            ->label('First Name')
                            ->required(),
                        TextInput::make('mname')
                            ->afterStateUpdated(function (Closure $get, Closure $set) {
                                $set('user.name', ($get('fname') ? $get('fname') : '') . ' ' . ($get('mname') ? $get('mname')[0] : '') . '. ' . ($get('lname') ? $get('lname') : ''));
                            })
                            ->reactive()
                            ->label('Middle Name')
                            ->required(),
                        TextInput::make('lname')
                            ->afterStateUpdated(function (Closure $get, Closure $set) {
                                $set('user.name', ($get('fname') ? $get('fname') : '') . ' ' . ($get('mname') ? $get('mname')[0] : '') . '. ' . ($get('lname') ? $get('lname') : ''));
                                $set('user.password', Hash::make(($get('fname') ? $get('fname') : '') . ($get('id') ? $get('id') : '')));
                            })
                            ->label('Last Name')
                            ->reactive()
                            ->required(),
                        Fieldset::make('')
                            ->relationship('user')
                            ->schema([
                                TextInput::make('email')
                                    ->email()
                                    ->unique(User::class, 'email', fn ($record) => $record)
                                    ->label('Email')
                                    ->required(),
                                TextInput::make('contact_number')
                                    ->mask(fn (TextInput\Mask $mask) => $mask->pattern('+{639} 000 000 000'))
                                    ->label('Contact Number'),
                                Group::make([
                                    TextInput::make('name')
                                        ->label('')
                                        ->extraAttributes(['class' => 'hidden']),
                                    TextInput::make('role_id')
                                        ->label('')
                                        ->default(3)
                                        ->extraAttributes(['class' => 'hidden']),
                                    TextInput::make('password')
                                        ->password()
                                        ->hidden(fn ($record) => $record)
                                        ->label('')
                                        ->extraAttributes(['class' => 'hidden'])
                                ])->columns(3)->columnSpan(2),
                            ])
                            ->columnSpan(2)
                            ->extraAttributes(['class' => 'border-0 p-0']),
                        Select::make('year_id')
                            ->relationship('year', 'year')
                            ->required(),
                        Group::make([
                            Select::make('program_id')
                                ->relationship('program', 'name')
                                ->required()
                                ->columnSpan('1.5'),
                            Select::make('sponsor_id')
                                ->relationship('sponsor', 'name')
                                ->required(),
                        ])->columnSpan(3)->columns(2),
                    ])->columnSpan(2)->columns(3),
                    Section::make('')->schema([
                        TextInput::make('id')
                            ->mask(fn (TextInput\Mask $mask) => $mask->pattern('0000 000 000'))
                            ->unique(Scholar::class, 'id', fn ($record) => $record)
                            ->disabled(fn ($record) => $record)
                            // ->reactive()
                            ->required()
                            ->label('ID #'),
                        Select::make('scholar_status_id')
                            ->relationship('scholar_status', 'status')
                            ->required(),
                        Select::make('last_allowance_receive')
                            ->relationship('allowance_receive', 'year')
                            ->required()
                            ->extraAttributes(['class'=>'space-y-2']),
                    ])->columnSpan(1),
                ])->columns(3)
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.email'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
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
    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query();
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListScholars::route('/'),
            'create' => Pages\CreateScholar::route('/create'),
            'edit' => Pages\EditScholar::route('/{record}/edit'),
        ];
    }
}
