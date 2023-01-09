<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Filament\Resources\AnnouncementResource\RelationManagers;
use App\Models\Announcement;
use App\Models\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;
    protected static ?string $modelLabel = "Announcement";
    protected static ?string $navigationIcon = 'fas-bullhorn';
    protected static ?string $navigationGroup = "Announcement Management";

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                Group::make([
                    Card::make([
                        TextInput::make('title'),
                        MarkdownEditor::make('body')
                    ])->columnSpan(2)->columns(1),
                    Forms\Components\Card::make()
                        ->schema([
                            Forms\Components\Placeholder::make('user.name')
                                ->label('Created: ')
                                ->content(fn ($record): string => $record->user->name),
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Created at')
                                ->content(fn ($record): string => $record->created_at->diffForHumans()),


                        ])
                        ->columnSpan(1)
                ])->columns(3)
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('body')
                    ->limit(20),
                // TextColumn::make('recipients_count')
                //     ->sortable()
                //     ->counts('recipients')
                //     ->label('Recipients')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    public static function getEloquentQuery(): Builder
    {

        $user = auth()->user();
        $id = $user->role_id;
        // dd(auth()->user()->id);
        if($id === Role::where('role','Scholar')->first()->id){
            $announcements = [] ;
            // ignore error
            foreach (User::firstWhere('id',$user->id)->announcements()->get() as $value) {
                $announcements [] = $value->id;
            }
            return static::getModel()::whereIn('id',$announcements);
        }else if($id === Role::where('role','Organization')->first()->id) {
            // dd(static::getModel()::whereRelation('user','user_id',$user->id)->get());
            // return static::getModel()::whereRelation('user','user_id',$user->id)->get();
        }

        return static::getModel()::query();
    }
    public static function getRelations(): array
    {
        return [
            RelationManagers\UsersRelationManager::class,
            RelationManagers\RequirementsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAnnouncements::route('/'),
            'view' => Pages\ViewAnnouncement::route('/{record}'),
        ];
    }
}
