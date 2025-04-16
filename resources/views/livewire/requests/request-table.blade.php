@php
    use App\Enums\RequestPriority;
    use App\Enums\RequestStatus;
@endphp


<table class="min-w-full divide-y divide-gray-200">
    <thead class="page-dark">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                <button wire:click="sortBy('title')" class="flex items-center">
                    Title
                    @if($sortField === 'title')
                        <x-sort-icon :direction="$sortDirection" />
                    @endif
                </button>
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Priority</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                <button wire:click="sortBy('created_at')" class="flex items-center">
                    Created At
                    @if($sortField === 'created_at')
                        <x-sort-icon :direction="$sortDirection" />
                    @endif
                </button>
            </th>
            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse($requests as $request)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <a href="{{ route('requests.show', $request) }}" class="hover:text-blue-600 text-sm font-medium text-gray-900">
                        {{ $request->title }}
                    </a>
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
                    @if(auth()->user()->isAdmin() || auth()->user()->id === $request->user_id)
                        <a href="{{ route('requests.show', $request) }}" class="text-blue-900 hover:text-blue-900 mr-3">
                            <i class="fas fa-eye mr-1"></i>
                        </a>
                    @endif
                    @can('update', $request)
                        <a href="{{ route('requests.edit', $request) }}" class="text-indigo-900 hover:text-indigo-900 mr-3">
                            <i class="fas fa-edit mr-1"></i>
                        </a>
                    @endcan
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
                    <i class="fas fa-exclamation-circle text-gray-400" style="font-size: 48px;"></i>
                    <div class="mt-2">No requests found.</div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>


