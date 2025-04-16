<div>
    <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
        <h2 class="text-xl font-semibold">Internal Requests</h2>
        @can('create', \App\Models\Request::class)
            <a href="{{ route('requests.create') }}" class="btn btn-dark flex items-center">
                <i class="fas fa-plus mr-2"></i> Create New Request
            </a>
        @endcan
    </div>

    <x-sort-icon :direction="$sortDirection" />

    <div class="card">
        <!-- تضمين الفلاتر -->
        @include('livewire.requests.filters')

        <div class="card-body">
            <div class="overflow-x-auto">
                <!-- تضمين جدول الطلبات -->
                @include('livewire.requests.request-table')
            </div>

            <div class="mt-4">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</div>
