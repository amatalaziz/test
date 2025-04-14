<?php

namespace App\Policies;

use App\Models\Request;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestPolicy
{
    use HandlesAuthorization;

    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Request $request)
    {
        return $user->id === $request->user_id || $user->isAdmin();
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Request $request)
    {
        return $user->id === $request->user_id || $user->isAdmin();
    }

    public function delete(User $user, Request $request)
    {
        return $user->id === $request->user_id || $user->isAdmin();
    }

    public function changeStatus(User $user)
    {
        return $user->isAdmin();
    }


    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Request $request)
    {
        //
    }
}
