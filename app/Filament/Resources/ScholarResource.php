<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScholarResource\Pages;
use App\Filament\Resources\ScholarResource\RelationManagers;
use App\Models\College;
use App\Models\Program;
use App\Models\Scholar;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Closure;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Support\Arr;

class ScholarResource extends Resource
{
    protected static ?string $model = Scholar::class;
    protected static ?string $modelLabel = 'Scholar';

    protected static ?string $navigationGroup = 'Scholarships Management';
    protected static ?string $navigationIcon = 'fas-user-tie';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        $colleges = College::all();
        $colleges = $colleges->pluck('name','id');
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->label('Name'),
                TextColumn::make('baranggay.name')
                    ->label('Baranggay'),
                BadgeColumn::make('status')
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
                    ->sortable()
                    ->label('Scholarship Program'),
                TextColumn::make('program.abbre')
                    ->formatStateUsing(fn ($state) => Str::upper($state))
                    ->label('Course'),
                TextColumn::make('program.college.abbre')
                    ->label('College'),
            ])
            ->filters([
                SelectFilter::make('baranggay')
                    ->multiple()
                    ->relationship('baranggay', 'name'),
                SelectFilter::make('scholarship_program')
                    ->multiple()
                    ->relationship('scholarship_program', 'name'),
                SelectFilter::make('status')
                    ->multiple()
                    ->options([
                        '1' => 'Pending',
                        '2' => 'Inactive',
                        '3' => 'Active',
                        '4' => 'Graduate',
                    ]),

                Filter::make('program')
                    ->form([
                        Select::make('college')
                            ->options($colleges)
                            ->afterStateUpdated(function ($component) {
                                $component->getContainer()->getComponents()[1]->fillStateWithNull();
                            })
                            ->placeholder('All')
                            ->reactive(),
                        Select::make('program')
                            ->multiple()
                            ->placeholder('All')
                            ->options(function (Closure $get) {
                                $program = Program::query();
                                $program->where('college_id', '=', $get('college'));
                                return $program->pluck('name', 'id');
                            })
                    ])->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['college'],
                                function (Builder $query, $colleges) {
                                    $inner_query = $query;
                                    $inner_query->whereRelation('college', 'college_id', '=', $colleges);
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
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        $colleges = [];
                        $programs = [];
                        if ($data['college'] ?? null)
                            $colleges[] = Str::upper(College::cacheFor(now()->addMinutes(1))->where('id', $data['college'])->first()->abbre);

                        if ($data['program'] ?? null)
                            foreach ($data['program'] as $value)
                                $programs[] = Str::upper(Program::where('id', $value)->first()->abbre);


                        $data['college'] ? $indicators['college'] = 'College: ' . Arr::join($colleges, ', ', ' & ') : null;
                        $data['program'] ? $indicators['program'] = 'Program: ' . Arr::join($programs, ', ', ' & ') : null;
                        return $indicators;
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageScholars::route('/'),
        ];
    }
}
