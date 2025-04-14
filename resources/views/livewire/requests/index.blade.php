@php
    use App\Enums\RequestPriority;
@endphp

@php
    use App\Enums\RequestStatus;
@endphp

<div>
    <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
        <h2 class="text-xl font-semibold">Internal Requests</h2>
        
        @can('create', \App\Models\Request::class)
            <a href="{{ route('requests.create') }}" class="btn btn-primary">
                Create New Request
            </a>
        @endcan
    </div>
    <x-sort-icon :direction="$sortDirection" />

    <div class="card">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <!-- Search -->
                <div>
                    <label for="search" class="sr-only">Search</label>
                    <input 
                        wire:model.debounce.300ms="search"
                        type="text" 
                        id="search" 
                        placeholder="Search requests..."
                        class="w-full input"
                    >
                </div>

                <!-- Priority Filter -->
                <div>
                    <label for="priority" class="sr-only">Priority</label>
                    <select 
                        wire:model="priority" 
                        id="priority" 
                        class="w-full input"
                    >
                        <option value="">All Priorities</option>
                        @foreach($priorities as $priority)
                            <option value="{{ $priority->value }}">{{ $priority->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="sr-only">Status</label>
                    <select 
                        wire:model="status" 
                        id="status" 
                        class="w-full input"
                    >
                        <option value="">All Statuses</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->value }}">{{ $status->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Reset Button -->
                <div>
                    <button 
                        wire:click="resetFilters" 
                        class="w-full btn btn-secondary"
                    >
                        Reset Filters
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <button wire:click="sortBy('title')" class="flex items-center">
                                    Title
                                    @if($sortField === 'title')
                                        <x-sort-icon :direction="$sortDirection" />
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Priority
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <button wire:click="sortBy('created_at')" class="flex items-center">
                                    Created At
                                    @if($sortField === 'created_at')
                                        <x-sort-icon :direction="$sortDirection" />
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($requests as $request)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <a href="{{ route('requests.show', $request) }}" class="hover:text-blue-600">
                                            {{ $request->title }}
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $request->priority_class }}">
                                        {{ RequestPriority::from($request->priority)->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $request->status_class }}">
                                        {{ RequestStatus::from($request->status)->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $request->created_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('requests.show', $request) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                    @can('update', $request)
                                        <a href="{{ route('requests.edit', $request) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</div>