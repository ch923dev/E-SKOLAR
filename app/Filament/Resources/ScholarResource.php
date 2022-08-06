<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScholarResource\Pages;
use App\Models\Academic;
use Filament\Tables\Filters\Filter;
use App\Models\College;
use App\Models\Program;
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
use Filament\Forms\Components\MultiSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ScholarResource extends Resource
{
    protected static ?string $model = Scholar::class;
    protected static ?string $modelLabel = 'Scholar';
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $pluralModelLabel = 'Scholars';
    protected static ?string $navigationGroup = 'Scholars Management';
    protected static ?int $navigationSort = 1;

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
                    ])->columnSpan(1),
                ])->columns(3)
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()
                    ->toggleable()
                    ->label('ID'),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->toggleable()
                    ->label('Name'),
                Tables\Columns\TextColumn::make('user.email')
                    ->searchable()
                    ->toggleable()
                    ->label('Email'),
                Tables\Columns\TextColumn::make('year.year')
                    ->toggleable()
                    ->label('Year Level'),
                Tables\Columns\TextColumn::make('program.abbre')
                    ->tooltip(function (Model $record) {
                        return Program::find($record->program_id)->name;
                    })
                    ->toggleable()
                    ->formatStateUsing(fn ($state) => Str::upper($state))
                    ->label('Program'),
                Tables\Columns\TextColumn::make('college.abbre')
                    ->tooltip(function (Model $record) {
                        return College::whereRelation('programs', 'id', $record->program_id)
                            ->first()->name;;
                    })
                    ->toggleable()
                    ->formatStateUsing(fn ($state) => Str::upper($state))
                    ->label('College'),
                Tables\Columns\TextColumn::make('sponsor.name')
                    ->toggleable()
                    ->tooltip(function (Model $record) {
                        return Sponsor::find($record->sponsor_id)->name;
                    })
                    ->limit(30)
                    ->label('Sponsor'),
                Tables\Columns\TextColumn::make('scholar_status.status')
                    ->toggleable()
                    ->label('Status'),
                Tables\Columns\TextColumn::make('allowance_receive.academicYearSem')
                    ->label('Last Allowance Receive'),

            ])
            ->filters([
                Filter::make('college_program')
                    ->form([
                        MultiSelect::make('college')
                            ->options(College::query()->pluck('name', 'id'))
                            ->afterStateUpdated(function ($component) {
                                $component->getContainer()->getComponents()[1]->fillStateWithNull();
                            })
                            ->placeholder('All')
                            ->reactive(),
                        MultiSelect::make('program')
                            ->placeholder('All')
                            ->options(function (Closure $get) {
                                $program = Program::query();
                                $count = 0;
                                foreach ($get('college') as $college) {
                                    ($count == 0) ?
                                        $program->where('college_id', '=', $college) :
                                        $program->orWhere('college_id', '=', $college);
                                    $count++;
                                }
                                return $program->pluck('name', 'id');
                            })
                    ])->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['college'],
                                function (Builder $query, $colleges) {
                                    $inner_query = $query;
                                    $count = 0;
                                    foreach ($colleges as $college) {
                                        ($count == 0) ?
                                            $inner_query->whereRelation('college', 'college_id', '=', $college) :
                                            $inner_query->orWhereRelation('college', 'college_id', '=', $college);
                                        $count++;
                                    }
                                    return $inner_query;
                                }
                            )
                            ->when(
                                $data['program'],
                                function (Builder $query, $programs) {
                                    $inner_query = $query;
                                    $count = 0;
                                    foreach ($programs as $program) {
                                        ($count == 0) ?
                                            $inner_query->whereRelation('program', 'program_id', '=', $program) :
                                            $inner_query->orWhereRelation('program', 'program_id', '=', $program);
                                        $count++;
                                    }
                                    return $inner_query;
                                }
                            );
                    }),
                MultiSelectFilter::make('sponsor')
                    ->relationship('sponsor', 'name')
                    ->label('Sponsor'),
                MultiSelectFilter::make('year')
                    ->relationship('year', 'year')
                    ->label('Year Level'),
                MultiSelectFilter::make('allowance')
                    ->options(Academic::query()->selectRaw('concat (year," ", IF(semester = 1, "1st Sem", "2nd Sem")) as sem , id')->pluck('sem', 'id'))
                    ->label('Last Allowance Receive')
                    ->column('allowance_receive.academicYearSem')
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
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
            'view' => Pages\ViewScholar::route('/{record}'),
            'edit' => Pages\EditScholar::route('/{record}/edit'),
        ];
    }
}
