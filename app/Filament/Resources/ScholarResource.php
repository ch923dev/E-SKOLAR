<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScholarResource\Pages;
use App\Filament\Resources\ScholarResource\RelationManagers;
use App\Models\College;
use App\Models\Program;
use App\Models\Scholar;
use App\Models\ScholarshipOrganization;
use App\Models\ScholarshipProgram;
use App\Models\Sponsor;
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
use Filament\Tables\Filters\Layout;
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
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->label('Name'),
                TextColumn::make('baranggay.name')
                    ->sortable()
                    ->label('Barangay'),
                TextColumn::make('sponsor.sponsor')
                    ->toggleable()
                    ->sortable()
                    ->label('Sponsor'),
                TextColumn::make('scholarship_program.name')
                    ->toggleable()
                    ->sortable()
                    ->label('Scholarship Program'),
                TextColumn::make('college.abbre')
                    ->sortable()
                    ->toggleable()
                    ->tooltip(fn ($record) => College::where('abbre', $record->college->abbre)->first()->name)
                    ->formatStateUsing(fn ($state) => Str::upper($state))
                    ->label('College'),
                TextColumn::make('program.abbre')
                    ->sortable()
                    ->toggleable()
                    ->tooltip(fn ($record) => Program::where('abbre', $record->program->abbre)->first()->name)
                    ->formatStateUsing(fn ($state) => Str::upper($state))
                    ->label('Course'),
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
            ])
            ->filters([
                Filter::make('scholarship')
                    ->form([
                        Select::make('sponsor')
                            ->label('Scholarship Sponsor')
                            ->multiple()
                            ->placeholder('All')
                            ->options(Sponsor::pluck('sponsor', 'id')),
                        Select::make('scholarship_organization')
                            ->label('Scholarship Organization')
                            ->multiple()
                            ->placeholder('All')
                            ->options(function ($get) {
                                return $get('sponsor') ?
                                    ScholarshipOrganization::whereRelation('sponsors', function (Builder $query) use ($get) {
                                        return $query->whereIn('sponsor_id', $get('sponsor'));
                                    })->pluck('name', 'id') : ScholarshipOrganization::pluck('name', 'id');
                            }),
                        Select::make('scholarship_program')
                            ->label('Scholarship Program')
                            ->multiple()
                            ->placeholder('All')
                            ->options(function (Closure $get) {
                                return $get('sponsor') ? ScholarshipProgram::whereIn('sponsor_id', $get('sponsor'))->pluck('name', 'id') : ScholarshipProgram::pluck('name', 'id');
                            })
                    ])->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['sponsor'],
                                function (Builder $query, $sponsors) {
                                    return $query->whereRelation('sponsor', function (Builder $query) use ($sponsors) {
                                        return $query->whereIn('sponsor_id', $sponsors);
                                    });
                                }
                            )
                            ->when(
                                $data['scholarship_organization'],
                                function (Builder $query, $scholarship_organizations) {
                                    return $query->whereRelation('scholarship_organization', function (Builder $query) use ($scholarship_organizations) {
                                        return $query->whereIn('scholarship_organization_id', $scholarship_organizations);
                                    });
                                }
                            )
                            ->when(
                                $data['scholarship_program'],
                                function (Builder $query, $scholarship_programs) {
                                    return $query->whereRelation('scholarship_program', function (Builder $query) use ($scholarship_programs) {
                                        return $query->whereIn('scholarship_program_id', $scholarship_programs);
                                    });
                                }
                            );;
                    }),
                Filter::make('curriculum')
                    ->form([
                        Select::make('college')
                            ->multiple()
                            ->options(College::pluck('name', 'id'))
                            ->placeholder('All'),
                        Select::make('program')
                            ->multiple()
                            ->placeholder('All')
                            ->options(function (Closure $get) {
                                return $get('college') ? Program::whereIn('college_id', $get('college'))->pluck('name', 'id') : Program::pluck('name', 'id');
                            })
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['college'],
                                function (Builder $query, $colleges) {
                                    return $query->whereRelation('college', function (Builder $query) use ($colleges) {
                                        return $query->whereIn('college_id', $colleges);
                                    });
                                }
                            )
                            ->when(
                                $data['program'],
                                function (Builder $query, $programs) {
                                    return $query->whereRelation('program', function (Builder $query) use ($programs) {
                                        return $query->whereIn('program_id', $programs);
                                    });
                                }
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        $colleges = [];
                        $programs = [];
                        if ($data['college'] ?? null)
                            foreach ($data['college'] as $value)
                                $colleges[] = Str::upper(College::where('id', $value)->first()->abbre);

                        if ($data['program'] ?? null)
                            foreach ($data['program'] as $value)
                                $programs[] = Str::upper(Program::where('id', $value)->first()->abbre);


                        $data['college'] ? $indicators['college'] = 'College: ' . Arr::join($colleges, ', ', ' & ') : null;
                        $data['program'] ? $indicators['program'] = 'Course: ' . Arr::join($programs, ', ', ' & ') : null;
                        return $indicators;
                    }),
                SelectFilter::make('baranggay')
                    ->label('Barangay')
                    ->multiple()
                    ->relationship('baranggay', 'name'),
                SelectFilter::make('status')
                    ->label('Scholarship Status')
                    ->multiple()
                    ->options([
                        '1' => 'Pending',
                        '2' => 'Inactive',
                        '3' => 'Active',
                        '4' => 'Graduate',
                    ]),
            ], layout: Layout::BelowContent)
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
