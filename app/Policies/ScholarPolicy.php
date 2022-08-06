<?php

namespace App\Policies;

use App\Models\Scholar;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScholarPolicy
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
        return $user->permissions->where('name', 'View Scholars')->first() ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Scholar  $scholar
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Scholar $scholar)
    {
        return $user->permissions->where('name', 'View Scholars')->first() ? true : false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->permissions->where('name', 'Manage Scholars')->first() ? true : false;

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Scholar  $scholar
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Scholar $scholar)
    {
        return $user->permissions->where('name', 'Manage Scholars')->first() ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Scholar  $scholar
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Scholar $scholar)
    {
        return $user->permissions->where('name', 'Manage Scholars')->first() ? true : false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Scholar  $scholar
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Scholar $scholar)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Scholar  $scholar
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Scholar $scholar)
    {
        //
    }
}
