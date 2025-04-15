@php
    use App\Enums\RequestPriority;
    use App\Enums\RequestStatus;
@endphp

<div x-data="{ showComments: false }" class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800"> Request Details</h2>
        <a href="{{ route('requests.index') }}" class="btn btn-light">
            ← Back to List
        </a>
    </div>

    {{-- Request Card --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">{{ $request->title }}</h2>
            <p class="text-sm text-gray-500">
                Created At: {{ $request->created_at->format('M d, Y H:i') }}
            </p>
        </div>



<div class="flex items-center justify-end mb-4">
    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $request->priority_class }}">
        {{ RequestPriority::from($request->priority)->label() }}
    </span>
    <div class="ml-4">
        @if(auth()->user()->isAdmin())
            <div x-data="{ open: false }" class="relative inline-block">
                <button @click="open = !open" class="px-3 py-1 rounded-full text-sm font-medium {{ $request->status_class }}">
                    {{ RequestStatus::from($request->status)->label() }}
                    <i class="fas fa-chevron-down ml-1"></i>
                </button>
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg z-10">
                    @foreach($statuses as $status)
                        @if($status->value !== $request->status)
                            <button wire:click="updateStatus('{{ $status->value }}')" class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ $status->label() }}
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>
        @else
            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $request->status_class }}">
                {{ RequestStatus::from($request->status)->label() }}
            </span>
        @endif
    </div>
</div>

    <h3 class="text-md font-semibold text-gray-800 mb-2">📝 Description</h3>
    <p class="text-gray-700 whitespace-pre-line mb-4">{{ $request->description }}</p>

    <div class="flex justify-end">
        @can('update', $request)
            <a href="{{ route('requests.edit', $request) }}" class="btn btn-dark flex items-center">
                 Edit Request
            </a>
        @endcan
    </div>
</div>
    <!-- </div> -->

    <hr>

    {{-- Comments Section --}}
    <div class="mt-10">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">💬 Comments</h3>
        <button @click="showComments = !showComments" class="btn btn-light mb-4">
            <span x-text="showComments ? 'Hide Comments' : 'Show Comments'"></span>
        </button>

        <div x-show="showComments" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @if($request->comments->count())
                @foreach($request->comments as $comment)
                    <div class="card p-4 shadow-sm border bg-white">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-medium text-gray-800">{{ $comment->user->name }}</span>
                            <span class="text-sm text-gray-500">{{ $comment->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="border-t border-gray-300 mt-2 pt-2 table-shadow p-4 rounded-xl">
                            <i class="fas fa-comment-dots text-blue-600" style="font-size: 24px;"></i>
                            <p class="text-gray-700 whitespace-pre-line text-sm mt-1">
                                {{ $comment->content }}
                            </p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="flex items-center">
                    <i class="fas fa-comment-slash text-gray-500" style="font-size: 48px;"></i>
                    <p class="text-gray-500 italic ml-2">No comments yet.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Add Comment --}}
    <div class="mt-8 border-t pt-6">
        <h3 class="text-lg font-semibold mb-3">➕ Add Comment</h3>
        <form wire:submit.prevent="addComment" class="flex flex-col">
            <textarea wire:model="comment" rows="2" class="w-3/4 input mb-2" placeholder="Write your comment here..." required></textarea>
            <div class="flex justify-end">
                <button type="submit" class="btn btn-dark flex items-center justify-center p-2">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
    </div>
</div>


<!-- attchment -->

<div class="mb-6">
    <h3 class="text-lg font-medium mb-4">Attachments</h3>
    
    <div class="mb-4">
        <form wire:submit.prevent="addAttachments">
            <div class="mb-2">
                <label for="attachments" class="block text-sm font-medium text-gray-700">Upload Files (Max 5 files, 5MB each)</label>
                <input 
                    type="file" 
                    wire:model="attachments" 
                    id="attachments" 
                    multiple
                    class="mt-1 block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100"
                >
                @error('attachments.*') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn btn-dark" wire:loading.attr="disabled">
                <span wire:loading.remove>Upload Files</span>
                <span wire:loading>Uploading...</span>
            </button>
        </form>
    </div>

    <div class="space-y-2">
        @forelse($request->attachments as $attachment)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md">
                <div class="flex items-center">
                    <i class="fas {{ $attachment->file_icon }} text-gray-500 mr-3"></i>
                    <span class="text-sm">{{ $attachment->original_name }}</span>
                    <span class="text-xs text-gray-500 ml-2">{{ formatBytes($attachment->size) }}</span>
                </div>
                <div class="flex space-x-2">
                    <button 
                        wire:click="downloadAttachment({{ $attachment->id }})" 
                        class="text-blue-600 hover:text-blue-800 text-sm"
                    >
                        Download
                    </button>
                    @if(auth()->id() === $attachment->user_id || auth()->user()->isAdmin())
                        <button 
                            wire:click="deleteAttachment({{ $attachment->id }})" 
                            class="text-red-600 hover:text-red-800 text-sm"
                            onclick="confirm('Are you sure you want to delete this file?') || event.stopImmediatePropagation()"
                        >
                            Delete
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-500">No attachments yet.</p>
        @endforelse
    </div>
</div>