<?php

namespace App\Filament\Resources\AnnouncementResource\Pages;

use App\Filament\Resources\AnnouncementResource;
use App\Models\Role;
use App\Models\User;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\DB;

class ManageAnnouncements extends ManageRecords
{
    protected static string $resource = AnnouncementResource::class;

    protected function getActions(): array
    {
        $roles = Role::whereNot('role', 'Deactivated')->pluck('role', 'id');
        $scholarship_programs = [];
        foreach (DB::table('scholarship_programs')->get() as $value) {
            $scholarship_programs[$value->id] = $value->name;
        }
        $programs = [];
        foreach (DB::table('programs')->get() as $value) {
            $programs[$value->id] = $value->name;
        }
        $baranggays = [];
        foreach (DB::table('baranggays')->get() as $value) {
            $baranggays[$value->id] = $value->name;
        }
        return [
            Actions\CreateAction::make()
                ->steps([
                    Step::make('Announcement')
                        ->schema([
                            TextInput::make('title')
                                ->required(),
                            MarkdownEditor::make('body')
                                ->required()
                        ]),
                    Step::make('Recipients Role')
                        ->schema([
                            Select::make('users_role')
                                ->placeholder('All')
                                ->options($roles)
                                ->reactive(),
                        ]),
                    Step::make('Recipients')
                        ->schema([
                            Select::make('scholarship_programs')
                                ->hidden(fn ($get) => empty($get('users_role')) || $get('users_role') != 4)
                                ->options($scholarship_programs)
                                ->multiple(),
                            Select::make('programs')
                                ->hidden(fn ($get) => empty($get('users_role')) || $get('users_role') != 4)
                                ->options($programs)
                                ->multiple(),
                            Select::make('baranggays')
                                ->hidden(fn ($get) => empty($get('users_role')) || $get('users_role') != 4)
                                ->options($programs)
                                ->multiple(),
                        ])
                ])
                ->using(function ($data) {
                    $data['user_id'] = auth()->user()->id;
                    $query = User::with(['scholarship_program']);
                    //Checking if there is roles
                    $query = $data['users_role'] ? $query->where('role_id', $data['users_role']) : $query;
                    // Check if there is scholarship programs
                    $query = $data['scholarship_programs'] ? $query->{'whereRelation'}('scholarship_program', 'scholarship_programs.id', $data['scholarship_programs']) : $query;
                    // Check if there is programs
                    $query = $data['programs'] ? $query->{'whereRelation'}('program', 'programs.id', $data['programs']) : $query;
                    // Check if there is baranggay
                    $query = $data['baranggays'] ? $query->{'whereRelation'}('baranggay', 'baranggays.id', $data['baranggay']) : $query;
                    $announcement = static::getModel()::create($data);

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
                    $announcement->users()->saveMany($query->get());
                    return $announcement;
                })
        ];
    }
}
