<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Scanner;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScannerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the scanner can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list scanners');
    }

    /**
     * Determine whether the scanner can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Scanner  $model
     * @return mixed
     */
    public function view(User $user, Scanner $model)
    {
        return $user->hasPermissionTo('view scanners');
    }

    /**
     * Determine whether the scanner can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create scanners');
    }

    /**
     * Determine whether the scanner can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Scanner  $model
     * @return mixed
     */
    public function update(User $user, Scanner $model)
    {
        return $user->hasPermissionTo('update scanners');
    }

    /**
     * Determine whether the scanner can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Scanner  $model
     * @return mixed
     */
    public function delete(User $user, Scanner $model)
    {
        return $user->hasPermissionTo('delete scanners');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Scanner  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete scanners');
    }

    /**
     * Determine whether the scanner can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Scanner  $model
     * @return mixed
     */
    public function restore(User $user, Scanner $model)
    {
        return false;
    }

    /**
     * Determine whether the scanner can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Scanner  $model
     * @return mixed
     */
    public function forceDelete(User $user, Scanner $model)
    {
        return false;
    }
}
