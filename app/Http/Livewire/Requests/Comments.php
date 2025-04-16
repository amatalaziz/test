<?php

namespace App\Http\Livewire\Requests;

use App\Models\Comment;
use App\Models\Request as UserRequest;
use Livewire\Component;

class Comments extends Component
{
    public UserRequest $request;
    public $comment = '';

    protected $listeners = ['refreshComments' => '$refresh'];
    public function addComment()
    {
        $this->validate([
            'comment' => [
                'required',
                'string',
                'max:1000',
                'regex:/^[\pL\s\d\-،.؟?!\r\n]+$/u',
            ],
        ]);
    
        Comment::create([
            'content' => $this->comment,
            'request_id' => $this->request->id,
            'user_id' => auth()->id(),
        ]);
    
        $this->comment = '';
        $this->emitSelf('refreshComments');
        $this->dispatchBrowserEvent('notify', 'add sucess');
    }
    

    public function render()
    {
        return view('livewire.requests.comments', [
            'comments' => $this->request->comments()->latest()->get(),
        ]);
    }
}
