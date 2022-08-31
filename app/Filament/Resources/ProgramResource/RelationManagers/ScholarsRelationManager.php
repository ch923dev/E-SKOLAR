<?php

namespace App\Filament\Resources\ProgramResource\RelationManagers;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Models\Scholar;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Contracts\HasRelationshipTable;
use Filament\Tables\Filters\MultiSelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ScholarsRelationManager extends RelationManager
{
    protected static string $relationship = 'scholars';
    protected static ?string $modelLabel = 'Scholar';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                Forms\Components\Group::make([
                    Forms\Components\Section::make('Personal Information')->schema([
                        Forms\Components\Group::make([
                            Forms\Components\Group::make([
                                Forms\Components\Placeholder::make('Avatar'),
                                Forms\Components\FileUpload::make('user.avatar_url')
                                    ->avatar()
                            ])->columnSpan(1),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('fname')
                                    ->label('First Name')
                                    ->required(),
                                Forms\Components\TextInput::make('mname')
                                    ->label('Middle Name')
                                    ->required(),
                                Forms\Components\TextInput::make('lname')
                                    ->label('Last Name')
                                    ->required(),
                            ])->columnSpan(2),
                        ])->columns(3),
                        Forms\Components\Group::make([
                            Forms\Components\TextInput::make('user.email')
                                ->email()
                                ->unique(User::class, 'email', fn ($record) => $record)
                                ->label('Email')
                                ->required(),
                            Forms\Components\TextInput::make('user.contact_number')
                                ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask->pattern('+{639} 000 000 000'))
                                ->label('Contact Number'),
                        ])->columns(2),
                    ])->columns(1),
                    Forms\Components\Group::make([
                        Forms\Components\Section::make('School Information')->schema([
                            Forms\Components\TextInput::make('id')
                                ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask->pattern('0000 000 000'))
                                ->unique(Scholar::class, 'id', fn ($record) => $record)
                                // ->reactive()
                                ->required()
                                ->label('ID #'),
                            Forms\Components\Select::make('year_id')
                                ->label('Year Level')
                                ->relationship('year', 'year')
                                ->required(),
                        ])->columnSpan(1),
                        Forms\Components\Section::make('Scholarship Information')->schema([
                            Forms\Components\Select::make('sponsor_id')
                                ->label('Sponsor')
                                ->relationship('sponsor', 'name')
                                ->required(),
                            Forms\Components\Select::make('scholar_status_id')
                                ->label('Scholar Status')
                                ->relationship('scholar_status', 'status')
                                ->required(),
                            Forms\Components\Select::make('last_allowance_receive')
                                ->label('Last Allowance Receive')
                                ->relationship('allowance_receive', 'year')
                                ->required()
                        ])->columnSpan(1),
                    ])->columns(2)
                ])
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID'),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('Name'),
                Tables\Columns\TextColumn::make('user.email')
                    ->searchable()
                    ->label('Email'),
                Tables\Columns\TextColumn::make('year.year')
                    ->label('Year Level'),
            ])
            ->filters([
                MultiSelectFilter::make('year')
                    ->relationship('year', 'year')
                    ->label('Year Level'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->using(function (HasRelationshipTable $livewire, array $data): Model {
                        // dd($data['user']);
                        $data['user']['name'] = $data['fname'] . ' ' . $data['mname'][0] . '. ' . $data['lname'];
                        $data['user']['password'] = Str::slug($data['user']['name']);
                        $data['user']['role_id'] = 3;
                        $data['user_id'] = User::firstOrCreate(
                            [
                                'email' => $data['user']['email']
                            ],
                            [
                                'name' => $data['user']['name'],
                                'password' => $data['user']['password'],
                                'role_id' => $data['user']['role_id'],
                                'contact_number' => $data['user']['contact_number'],
                                'avatar_url' => $data['user']['avatar_url'],
                            ]
                        )->id;
                        return $livewire->getRelationship()->create($data);
                    })
                // FilamentExportHeaderAction::make('export')
                //     ->disablePreview()
                //     ->disableAdditionalColumns()
                //     ->button(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->mutateRecordDataUsing(function (array $data, Model $record) {
                            // dd($record->user->avatar_url);
                            $data['user']['contact_number'] = $record->user->contact_number;
                            $data['user']['email'] = $record->user->email;
                            $data['user']['avatar_url'] = Str::remove('/storage/', $record->user->avatar_url);
                            return $data;
                        })->label('View Scholar'),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
