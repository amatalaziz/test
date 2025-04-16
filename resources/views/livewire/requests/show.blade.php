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


<!-- comment inculde -->
    @livewire('requests.comments', ['request' => $request])

 
  
