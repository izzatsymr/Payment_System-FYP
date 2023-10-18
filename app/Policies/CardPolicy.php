<?php

namespace App\Policies;

use App\Models\Card;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CardPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the card can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list cards');
    }

    /**
     * Determine whether the card can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Card  $model
     * @return mixed
     */
    public function view(User $user, Card $model)
    {
        return $user->hasPermissionTo('view cards');
    }

    /**
     * Determine whether the card can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create cards');
    }

    /**
     * Determine whether the card can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Card  $model
     * @return mixed
     */
    public function update(User $user, Card $model)
    {
        return $user->hasPermissionTo('update cards');
    }

    /**
     * Determine whether the card can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Card  $model
     * @return mixed
     */
    public function delete(User $user, Card $model)
    {
        return $user->hasPermissionTo('delete cards');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Card  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete cards');
    }

    /**
     * Determine whether the card can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Card  $model
     * @return mixed
     */
    public function restore(User $user, Card $model)
    {
        return false;
    }

    /**
     * Determine whether the card can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Card  $model
     * @return mixed
     */
    public function forceDelete(User $user, Card $model)
    {
        return false;
    }
}
