<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Delete Request') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-red-700 mb-4">
                        <i class="bi bi-exclamation-triangle-fill text-red-600"></i>
                        Are you sure you want to delete this request?
                    </h3>

                    <div class="mb-6">
                        <p><strong>Title:</strong> {{ $request->title }}</p>
                        <p class="mt-2"><strong>Description:</strong></p>
                        <p class="whitespace-pre-line text-gray-700">{{ $request->description }}</p>
                        <p class="mt-2"><strong>Priority:</strong> {{ $request->priority->label() }}</p>
                        <p class="mt-2"><strong>Status:</strong> {{ $request->status->label() }}</p>
                    </div>

                    <form method="POST" action="{{ route('requests.destroy', $request) }}">
                        @csrf
                        @method('DELETE')

                        <div class="flex items-center justify-end">
                            <a href="{{ route('requests.index') }}" class="mr-4 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-300 focus:outline-none focus:border-gray-300 focus:ring focus:ring-gray-200 disabled:opacity-25 transition">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 disabled:opacity-25 transition">
                                Confirm Delete
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
