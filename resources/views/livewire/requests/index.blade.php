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
        <a href="{{ route('requests.create') }}" class="btn btn-dark flex items-center">
    <i class="fas fa-plus mr-2"></i> <!-- أيقونة الإضافة -->
    Create New Request
</a>

        @endcan
    </div>
    <x-sort-icon :direction="$sortDirection" />
  
    <div class="card">
    <!-- <div class="z-10 mt-4 mb-8"> -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-white p-4 rounded-lg shadow-md">
            <!-- Search -->
            <div class="input-container">
                <i class="fas fa-search input-icon"></i>
                <label for="search" class="sr-only">Search</label>
                <input 
                    wire:model.debounce.300ms="search"
                    type="text" 
                    id="search" 
                    placeholder="Search requests..."
                    class="input"
                >
            </div>

            <!-- Priority Filter -->
            <div class="input-container">
                <i class="fas fa-exclamation-circle input-icon"></i>
                <label for="priority" class="sr-only">Priority</label>
                <select 
                    wire:model="priority" 
                    id="priority" 
                    class="input"
                >
                    <option value="">All Priorities</option>
                    @foreach($priorities as $priority)
                        <option value="{{ $priority->value }}">{{ $priority->label() }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div class="input-container">
                <i class="fas fa-flag input-icon"></i>
                <label for="status" class="sr-only">Status</label>
                <select 
                    wire:model="status" 
                    id="status" 
                    class="input"
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
                    class="w-full btn btn-light flex items-center"
                >
                    <i class="fas fa-redo mr-2"></i>
                    Reset Filters
                </button>
            </div>
        <!-- </div> -->
    </div>
        <div class="card-body">
     

            <div class="overflow-x-auto">
                
                <table class="min-w-full divide-y divide-gray-200 ">
                    <thead class="page-dark">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                <button wire:click="sortBy('title')" class="flex items-center">
                                    Title
                                    @if($sortField === 'title')
                                        <x-sort-icon :direction="$sortDirection" />
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                Priority
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium  uppercase tracking-wider">
                                <button wire:click="sortBy('created_at')" class="flex items-center">
                                    Created At
                                    @if($sortField === 'created_at')
                                        <x-sort-icon :direction="$sortDirection" />
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium  uppercase tracking-wider">
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
    <!-- عرض الرابط للمستخدمين الذين يملكون الطلب أو للمشرفين فقط -->
    @if(auth()->user()->isAdmin() || auth()->user()->id === $request->user_id)
        <a href="{{ route('requests.show', $request) }}" class="text-blue-900 hover:text-blue-900 mr-3">
            <i class="fas fa-eye mr-1"></i>
        </a>
    @endif

    <!-- عرض رابط التعديل للمشرفين أو لصاحب الطلب -->
    @can('update', $request)
        <a href="{{ route('requests.edit', $request) }}" class="text-indigo-900 hover:text-indigo-900 mr-3">
            <i class="fas fa-edit mr-1"></i>
        </a>
    @endcan

    <!-- عرض زر الحذف للمشرفين أو لصاحب الطلب -->
    @can('delete', $request)
        <form action="{{ route('requests.destroy', $request) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this request?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-700 hover:text-red-900">
                <i class="fas fa-trash-alt mr-1"></i>
            </button>
        </form>
    @endcan
</td>


                            </tr>
                        @empty
                            <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
    <i class="fas fa-exclamation-circle text-gray-400" style="font-size: 48px;"></i> <!-- أيقونة كبيرة -->
    <div class="mt-2">No requests found.</div>
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