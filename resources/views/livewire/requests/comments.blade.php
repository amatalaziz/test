<div x-data="{ showComments: false }" class="mt-10">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">💬 Comments</h3>
    <button @click="showComments = !showComments" class="btn btn-light mb-4">
        <span x-text="showComments ? 'Hide Comments' : 'Show Comments'"></span>
    </button>

    <div x-show="showComments" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($comments as $comment)
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
        @empty
            <div class="flex items-center">
                <i class="fas fa-comment-slash text-gray-500" style="font-size: 48px;"></i>
                <p class="text-gray-500 italic ml-2">No comments yet.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8 border-t pt-6">
        <h3 class="text-lg font-semibold mb-3">➕ Add Comment</h3>
        @include('components.alert-validation')
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
