@php
    use App\Enums\RequestPriority;
    use App\Enums\RequestStatus;
@endphp

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
        <select wire:model="priority" id="priority" class="input">
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
        <select wire:model="status" id="status" class="input">
            <option value="">All Statuses</option>
            @foreach($statuses as $status)
                <option value="{{ $status->value }}">{{ $status->label() }}</option>
            @endforeach
        </select>
    </div>

    <!-- Reset Button -->
    <div>
        <button wire:click="resetFilters" class="w-full btn btn-light flex items-center">
            <i class="fas fa-redo mr-2"></i>
            Reset Filters
        </button>
    </div>
</div>
