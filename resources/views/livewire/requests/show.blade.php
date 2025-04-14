@php
    use App\Enums\RequestPriority;
@endphp

@php
    use App\Enums\RequestStatus;
@endphp


<div>
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Request Details</h2>
        <a href="{{ route('requests.index') }}" class="btn btn-secondary">
            Back to List
        </a>
    </div>

    <div class="card mb-6">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <h3 class="text-lg font-medium">{{ $request->title }}</h3>
                    <p class="text-gray-600">{{ $request->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div class="flex flex-col md:flex-row md:items-center md:justify-end space-y-2 md:space-y-0 md:space-x-2">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $request->priority_class }}">
                        {{ RequestPriority::from($request->priority)->label() }}
                    </span>
                    @if(auth()->user()->isAdmin())
                        <div x-data="{ open: false }" class="relative">
                            <button 
                                @click="open = !open" 
                                class="px-3 py-1 rounded-full text-sm font-semibold {{ $request->status_class }}"
                            >
                                {{ RequestStatus::from($request->status)->label() }}
                                <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                            <div 
                                x-show="open" 
                                @click.away="open = false" 
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10"
                            >
                                @foreach($statuses as $status)
                                    @if($status->value !== $request->status)
                                        <button 
                                            wire:click="updateStatus('{{ $status->value }}')" 
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        >
                                            {{ $status->label() }}
                                        </button>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @else
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $request->status_class }}">
                            {{ RequestStatus::from($request->status)->label() }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="mb-6">
                <h4 class="text-md font-medium mb-2">Description</h4>
                <p class="text-gray-700 whitespace-pre-line">{{ $request->description }}</p>
            </div>

            @can('update', $request)
                <div class="flex justify-end">
                    <a href="{{ route('requests.edit', $request) }}" class="btn btn-primary">
                        Edit Request
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="mb-6">
        <h3 class="text-lg font-medium mb-4">Comments</h3>
        
        <div class="space-y-4">
            @forelse($request->comments as $comment)
                <div class="card">
                    <div class="card-body">
                        <div class="flex justify-between items-start mb-2">
                            <div class="font-medium">{{ $comment->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $comment->created_at->format('M d, Y H:i') }}</div>
                        </div>
                        <p class="text-gray-700 whitespace-pre-line">{{ $comment->content }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No comments yet.</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3 class="text-lg font-medium mb-4">Add Comment</h3>
            <form wire:submit.prevent="addComment">
                <div class="mb-4">
                    <label for="comment" class="sr-only">Comment</label>
                    <textarea 
                        wire:model="comment" 
                        id="comment" 
                        rows="3" 
                        class="w-full input" 
                        placeholder="Write your comment here..."
                        required
                    ></textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                    Post Comment
                </button>
            </form>
        </div>
    </div>
</div>