<div>
    <h3 class="text-lg font-medium mb-4 flex items-center gap-2">
        <i class="fas fa-tasks text-blue-500"></i>
        Approval Process
    </h3>
    
    <div class="space-y-4">
        @foreach($approvals as $approval)
            <div class="flex items-start gap-4 p-4 border rounded-lg 
                @if($approval->status === 'approved') bg-green-50 border-green-200 @endif
                @if($approval->status === 'rejected') bg-red-50 border-red-200 @endif">
                <div class="flex-shrink-0">
                    <div class="avatar">
                        <span class="initials">{{ substr($approval->user->name, 0, 1) }}</span>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium">{{ $approval->user->name }}</p>
                            <p class="text-sm text-gray-500">
                                Level {{ $approval->level }} • 
                                @if($approval->status === 'pending')
                                    <span class="text-yellow-500">Pending</span>
                                @elseif($approval->status === 'approved')
                                    <span class="text-green-500">Approved</span>
                                    • {{ $approval->approved_at->diffForHumans() }}
                                @else
                                    <span class="text-red-500">Rejected</span>
                                    • {{ $approval->approved_at->diffForHumans() }}
                                @endif
                            </p>
                        </div>
                        @if($approval->status !== 'pending')
                            <button class="text-gray-400 hover:text-blue-500" 
                                    x-tooltip="View comment">
                                <i class="fas fa-comment-dots"></i>
                            </button>
                        @endif
                    </div>
                    
                    @if($approval->comment)
                        <div class="mt-2 p-3 bg-white rounded-lg border">
                            <p class="text-gray-700">{{ $approval->comment }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    @if($currentApproval && auth()->id() === $currentApproval->user_id)
        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
            <h4 class="font-medium mb-3">Take Action</h4>
            <textarea wire:model="comment" rows="3" 
                class="w-full input-field mb-3" 
                placeholder="Add your comment (optional)"></textarea>
            <div class="flex justify-end gap-2">
                <button wire:click="reject" 
                        class="btn btn-danger flex items-center gap-2">
                    <i class="fas fa-times"></i> Reject
                </button>
                <button wire:click="approve" 
                        class="btn btn-success flex items-center gap-2">
                    <i class="fas fa-check"></i> Approve
                </button>
            </div>
        </div>
    @endif
</div>