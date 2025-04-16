<?php

namespace App\Policies;

use App\Models\Request as SupportRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
    
        return $user->isAdmin();
    }
    
    public function view(User $user, SupportRequest $request)
    {
   
        return $user->id === $request->user_id || $user->isAdmin();
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, SupportRequest $request)
    {
        return $user->id === $request->user_id ;
    }

    

    public function delete(User $user, SupportRequest $request)
    {
        return $user->id === $request->user_id || $user->isAdmin();
    }

    public function changeStatus(User $user)
    {
        return $user->isAdmin();
    }

// polcy for approve
    public function approve(User $user, Request $request)
{
    $currentApproval = $request->currentApproval();
    return $currentApproval && $currentApproval->user_id === $user->id;
}
 
}
