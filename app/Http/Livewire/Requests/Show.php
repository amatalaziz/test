<?php

namespace App\Http\Livewire\Requests;

use App\Enums\RequestPriority;
use App\Enums\RequestStatus;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Request;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Show extends Component
{
    public Request $request;
    public $comment = '';

    protected $listeners = ['refreshRequest' => '$refresh'];

    public function mount(Request $request)
    {
        $this->request = $request;
    }

    public function addComment()
    {
        $validated = $this->validate([
            'comment' => 'required|string|max:1000',
        ]);

        Comment::create([
            'content' => $validated['comment'],
            'request_id' => $this->request->id,
            'user_id' => auth()->id(),
        ]);

        $this->comment = '';
        $this->emitSelf('refreshRequest');
        $this->dispatchBrowserEvent('notify', 'Comment added successfully!');
    }

    public function updateStatus($status)
    {
        Gate::authorize('changeStatus', $this->request);

        $this->request->update(['status' => $status]);
        $this->emitSelf('refreshRequest');
        $this->dispatchBrowserEvent('notify', 'Status updated successfully!');
    }

    public function render()
    {
        return view('livewire.requests.show', [
            'priorities' => RequestPriority::cases(),
            'statuses' => RequestStatus::cases(),
        ]);
    }
}