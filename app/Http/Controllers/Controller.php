<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
  // public function update(SupportRequest $request)
    // {
    //     $request->fill(request()->only(['title', 'description', 'priority']));
    
    //     if ($request->isDirty()) {
    //         $request->save();
    //         $message = 'Request updated successfully.';
    //     } else {
    //         $message = 'No changes were made to the request.';
    //     }
    
    //     return redirect()->route('requests.index')
    //         ->with('success', $message);
    // }