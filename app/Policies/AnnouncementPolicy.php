<?php

namespace App\Policies;

use App\Models\Announcement;
use App\Models\Module;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnnouncementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // return Module::view(Module::level($user, User::class));
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Announcement $announcement)
    {
        // return Module::view(Module::level($user, User::class),$announcement);

        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return Module::manage(Module::level($user, Announcement::class));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Announcement $announcement)
    {
        return Module::manage(Module::level($user, Announcement::class), $announcement);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Announcement $announcement)
    {
        return Module::manage(Module::level($user, Announcement::class), $announcement);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Announcement $announcement)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Announcement $announcement)
    {
        //
    }
}
