<?php

namespace App\Filament\Resources\SponsorResource\RelationManagers;

use App\Models\Role;
use App\Models\Scholar;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ysfkaya\FilamentPhoneInput\PhoneInput;

class ScholarsRelationManager extends RelationManager
{
    protected static string $relationship = 'scholars';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->toggleable()
                    ->searchable()
                    ->label('Name'),
                TextColumn::make('baranggay.name')
                    ->toggleable()
                    ->label('Baranggay'),
                BadgeColumn::make('status')
                    ->toggleable()
                    ->sortable()
                    ->enum([
                        '1' => 'Pending',
                        '2' => 'Inactive',
                        '3' => 'Active',
                        '4' => 'Graduate',
                    ])
                    ->colors([
                        'primary',
                        'warning' => static fn ($state): bool => $state == '1',
                        'danger' => static fn ($state): bool => $state == '2',
                        'success' => static fn ($state): bool => $state == '3',
                        'success' => static fn ($state): bool => $state == '4',
                    ]),
                TextColumn::make('scholarship_program.name')
                    ->toggleable()
                    ->sortable()
                    ->label('Scholarship Program'),
                TextColumn::make('program.abbre')
                    ->toggleable()
                    ->formatStateUsing(fn ($state) => Str::upper($state))
                    ->label('Course'),
                TextColumn::make('college.abbre')
                    ->toggleable()
                    ->label('College'),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->using(function ($livewire, $data) {
                        $user = User::create([
                            'avatar_url' => 'pngtree-blue-default-avatar-png-image_2813123.jpg',
                            'email' => $data['user']['email'],
                            'contact_number' => $data['user']['contact_number'],
                            'name' => $data['fname'] . ' ' . $data['lname'],
                            'role_id' => Role::where('role', 'Scholar')->first()->id,
                            'password' => Hash::make(Carbon::now()->year . '-' . $data['lname']),
                        ]);
                        $data['user_id'] = $user->id;
                        $data['status'] = 3;
                        return $livewire->getRelationship()->create($data);
                    })
                    ->steps([
                        Step::make('Scholar Information')
                            ->schema([
                                Section::make('Personal Details')
                                    ->schema([
                                        Group::make([
                                            TextInput::make('fname')
                                                ->label('First Name')
                                                ->required(),
                                            TextInput::make('lname')
                                                ->label('Last Name')
                                                ->required(),
                                            TextInput::make('user.email')
                                                ->unique(User::class, 'email')
                                                ->label('Email')
                                                ->email()
                                                ->required(),
                                            PhoneInput::make('user.contact_number')
                                                ->required()
                                                ->initialCountry('ph')
                                                ->disallowDropdown()
                                                ->separateDialCode(true)
                                        ])->columns(2),
                                        Select::make('baranggay_id')
                                            ->relationship('baranggay', 'name')
                                            ->required()
                                            ->label('Baranggay'),
                                    ]),

                            ]),
                        Step::make('Curriculum Details')
                            ->schema([
                                Section::make('Curriculum Details')
                                    ->schema([
                                        Select::make('program_id')
                                            ->relationship('program', 'name')
                                            ->required()
                                    ]),
                            ]),
                        Step::make('Scholarship Program')
                            ->schema([
                                Section::make('Scholarship Program')
                                    ->schema([
                                        Select::make('scholarship_program_id')
                                            ->options(fn ($livewire) => $livewire->ownerRecord->scholarship_programs->pluck('name', 'id'))
                                            ->label('Scholarship Program')
                                            ->required()
                                    ])
                            ])
                    ]),


            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
