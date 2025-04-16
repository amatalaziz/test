<?php

namespace App\Http\Livewire\Requests;
use App\Http\Requests\StoreAttachmentRequest;
use App\Enums\RequestPriority;
use App\Enums\RequestStatus;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Attachment;
use App\Models\Request;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Notifications\RequestStatusChanged;


class Show extends Component
{

    use WithFileUploads;

    public $attachments = [];
    public Request $request;
    public $comment = '';

    protected $listeners = ['refreshRequest' => '$refresh'];

    public function mount(Request $request)
    {
        $this->request = $request;
    }

   


    // تعديل الحالات من قبل الادمن 

    public function updateStatus($status)
    {
       


        Gate::authorize('changeStatus', $this->request);

        $oldStatus = $this->request->status;
        $this->request->update(['status' => $status]);
        
        // Send notification to the request creator
        if ($this->request->user_id !== auth()->id()) {
            $this->request->user->notify(
                new RequestStatusChanged($this->request, $oldStatus)
            );
        }
    
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


    // attchment
    // public function addAttachments()
    // {
    //     $this->validate([
    //         'attachments' => 'sometimes|array|max:5',
    //         'attachments.*' => 'file|max:5120', // 5MB
    //     ]);

    //     foreach ($this->attachments as $file) {
    //         $path = $file->store('attachments/' . $this->request->id);

    //         Attachment::create([
    //             'original_name' => $file->getClientOriginalName(),
    //             'path' => $path,
    //             'mime_type' => $file->getMimeType(),
    //             'size' => $file->getSize(),
    //             'request_id' => $this->request->id,
    //             'user_id' => auth()->id(),
    //         ]);
    //     }

    //     $this->attachments = [];
    //     $this->emitSelf('refreshRequest');
    //     $this->dispatchBrowserEvent('notify', 'Files uploaded successfully!');
    // }

    // public function downloadAttachment($attachmentId)
    // {
    //     $attachment = Attachment::findOrFail($attachmentId);
    //     return Storage::download($attachment->path, $attachment->original_name);
    // }

    // public function deleteAttachment($attachmentId)
    // {
    //     $attachment = Attachment::findOrFail($attachmentId);
        
    //     Storage::delete($attachment->path);
    //     $attachment->delete();

    //     $this->emitSelf('refreshRequest');
    //     $this->dispatchBrowserEvent('notify', 'File deleted successfully!');
    // }




    
}