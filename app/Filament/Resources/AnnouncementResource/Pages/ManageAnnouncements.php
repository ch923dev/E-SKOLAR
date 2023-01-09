<?php

namespace App\Filament\Resources\AnnouncementResource\Pages;

use App\Filament\Resources\AnnouncementResource;
use App\Models\Program;
use App\Models\Requirement;
use App\Models\Role;
use App\Models\Scholar;
use App\Models\ScholarshipOrganization;
use App\Models\ScholarshipProgram;
use App\Models\User;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard\Step;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class ManageAnnouncements extends ManageRecords
{
    protected static string $resource = AnnouncementResource::class;

    protected function getActions(): array
    {
        $scholarship_programs = [];
        $scholarship_programs_total = [];
        foreach (DB::table('scholarship_programs')->get() as $value) {
            $scholarship_programs[$value->id] = $value->name;
            $scholarship_programs_total[$value->id] = $value->sponsor_id;
        }
        $programs = [];
        foreach (DB::table('programs')->get() as $value) {
            $programs[$value->id] = $value->name;
        }
        $colleges = [];
        foreach (DB::table('colleges')->get() as $value) {
            $colleges[$value->id] = $value->name;
        }
        $baranggays = [];
        foreach (DB::table('baranggays')->get() as $value) {
            $baranggays[$value->id] = $value->name;
        }
        $sponsors = [];
        foreach (DB::table('sponsors')->get() as $value) {
            $sponsors[$value->id] = $value->sponsor;
        }
        return [
            Actions\CreateAction::make()
                ->steps([
                    Step::make('Announcement')
                        ->schema([
                            TextInput::make('title')
                                ->required(),
                            RichEditor::make('body')
                                ->required(),
                            Toggle::make('is_requirement')
                                ->reactive()
                                ->label('Requirement'),
                            Repeater::make('requirements')
                                ->hidden(fn ($get) => !$get('is_requirement'))
                                ->label('Requirements')
                                ->createItemButtonLabel('Add Requirement')
                                ->schema([
                                    Group::make([
                                        TextInput::make('description')
                                            ->label('Description'),
                                        Select::make('filetypes')
                                            ->label('File Types')
                                            ->multiple()
                                            ->options([
                                                'application/pdf' => 'Portable Document Format/PDF',
                                                'application/vnd.ms-powerpoint' => 'Microsoft PowerPoint',
                                                'application/vnd.ms-excel' => 'Microsoft Excel',
                                                'text/csv' => 'Comma-separated values (CSV)',
                                                'image/jpeg' => 'JPEG images',
                                                'image/png' => 'PNG images',
                                            ]),
                                    ])->columns(2)
                                ]),
                        ]),
                    Step::make('Recipients')
                        ->schema([
                            Section::make('Filter by Scholarship')
                                ->schema([
                                    Select::make('sponsors')
                                        ->label('Sponsor')
                                        ->placeholder('All')
                                        ->options($sponsors)
                                        ->multiple(),
                                    Select::make('scholarship_organization')
                                        ->label('Scholarship Organization')
                                        ->default(1)
                                        // ->disabled(fn()=>auth()->user()->role_id === Role::firstWhere('role', 'Organization')->id)
                                        // ->multiple(fn()=>!auth()->user()->role_id === Role::firstWhere('role', 'Organization')->id)
                                        ->placeholder('All')
                                        ->options(function ($get) {
                                            $user = auth()->user();
                                            // if($user->role_id === Role::firstWhere('role', 'Organization')->id){
                                            //     ScholarshipOrganization::where('')->pluck('name','id');
                                            // }
                                            return $get('sponsors') ?
                                                ScholarshipOrganization::whereRelation('sponsors', function (Builder $query) use ($get) {
                                                    return $query->whereIn('sponsor_id', $get('sponsors'));
                                                })->pluck('name', 'id') : ScholarshipOrganization::pluck('name', 'id');
                                        }),
                                    Select::make('scholarship_programs')
                                        ->label('Scholarship Program')
                                        ->placeholder('All')
                                        ->options(fn ($get) => ScholarshipProgram::whereIn('sponsor_id', $get('sponsors'))->pluck('name', 'id'))
                                        ->multiple(),
                                ]),
                            Section::make('Filter by Curriculum')
                                ->schema([
                                    Select::make('colleges')
                                        ->label('College')
                                        ->placeholder('All')
                                        ->options($colleges)
                                        ->multiple(),
                                    Select::make('programs')
                                        ->label('Program')
                                        ->placeholder('All')
                                        ->options(fn ($get) => $get('colleges') ? Program::whereIn('college_id', $get('colleges'))->pluck('name', 'id') : $programs)
                                        ->multiple(),
                                ]),
                            Section::make('Filter by Scholar')
                                ->schema([
                                    Select::make('baranggays')
                                        ->label('Barangay')
                                        ->placeholder('All')
                                        ->options($baranggays)
                                        ->multiple(),
                                    Select::make('status')
                                        ->label('Scholarship Status')
                                        ->placeholder('All')
                                        ->options([
                                            '1' => 'Pending',
                                            '2' => 'Inactive',
                                            '3' => 'Active',
                                            '4' => 'Graduate',
                                        ])
                                        ->multiple()
                                ])
                        ])
                ])
                ->using(function ($data) {
                    $data['user_id'] = auth()->user()->id;
                    $query = User::with(['scholarship_program', 'program', 'baranggay'])->whereHas('scholar');
                    // Check if there is scholarship programs
                    $query = $data['scholarship_programs'] ? $query->{'whereRelation'}('scholarship_program', 'scholarship_programs.id', $data['scholarship_programs']) : $query;
                    // Check if there is programs
                    $query = $data['programs'] ? $query->{'whereRelation'}('program', 'programs.id', $data['programs']) : $query;
                    // Check if there is baranggay
                    $query = $data['baranggays'] ? $query->{'whereRelation'}('baranggay', 'baranggays.id', $data['baranggay']) : $query;
                    // Check if there is status
                    $query = $data['status'] ? $query->{'whereRelation'}('scholar', 'scholars.status', $data['status']) : $query;

                    $announcement = static::getModel()::create($data);

                    foreach ($data['requirements'] as $value) {
                        $requirement = new Requirement();
                        $requirement->description = $value['description'];
                        $requirement->filetypes = $value['filetypes'];
                        $requirement->announcement_id = $announcement->id;
                        $requirement->save();
                        $requirement->users()->saveMany($query->get());
                    }

                    Notification::make()
                        ->title($data['title'])
                        ->body($data['body'])
                        ->actions([
                            Action::make('view')
                                ->button()
                                ->url(
                                    url: route('filament.resources.announcements.view', $announcement)
                                )
                        ])
                        ->sendToDatabase($query->get());
                    $announcement->recipients()->saveMany($query->get());
                    return $announcement;
                })
        ];
    }
}
