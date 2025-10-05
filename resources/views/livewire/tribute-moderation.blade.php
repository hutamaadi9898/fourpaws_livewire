<div class="min-h-screen bg-slate-50 py-12 dark:bg-slate-900">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Tribute Moderation</h1>
            <p class="mt-2 text-slate-600 dark:text-slate-400">Review and moderate tributes for your memorials</p>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="mb-6 rounded-md bg-green-50 p-4 dark:bg-green-900/20">
                <p class="text-sm font-medium text-green-800 dark:text-green-300">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Filter Tabs --}}
        <div class="mb-6 border-b border-slate-200 dark:border-slate-700">
            <nav class="-mb-px flex space-x-8">
                <button 
                    wire:click="$set('statusFilter', 'pending')"
                    class="border-b-2 px-1 py-4 text-sm font-medium {{ $statusFilter === 'pending' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 dark:text-slate-400' }}"
                >
                    Pending
                </button>
                <button 
                    wire:click="$set('statusFilter', 'approved')"
                    class="border-b-2 px-1 py-4 text-sm font-medium {{ $statusFilter === 'approved' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 dark:text-slate-400' }}"
                >
                    Approved
                </button>
                <button 
                    wire:click="$set('statusFilter', 'rejected')"
                    class="border-b-2 px-1 py-4 text-sm font-medium {{ $statusFilter === 'rejected' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 dark:text-slate-400' }}"
                >
                    Rejected
                </button>
                <button 
                    wire:click="$set('statusFilter', 'all')"
                    class="border-b-2 px-1 py-4 text-sm font-medium {{ $statusFilter === 'all' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700 dark:text-slate-400' }}"
                >
                    All
                </button>
            </nav>
        </div>

        {{-- Tributes List --}}
        @if($tributes->isEmpty())
            <div class="rounded-lg bg-white p-12 text-center shadow dark:bg-slate-800">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-slate-900 dark:text-white">No tributes to moderate</h3>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                    {{ $statusFilter === 'pending' ? 'All tributes have been reviewed.' : 'No tributes with this status.' }}
                </p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($tributes as $tribute)
                    <div class="rounded-lg bg-white p-6 shadow dark:bg-slate-800">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                {{-- Memorial Info --}}
                                <div class="mb-3 flex items-center gap-2">
                                    <span class="inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                                        {{ $tribute->memorial->pet_name }}
                                    </span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">
                                        {{ $tribute->created_at->diffForHumans() }}
                                    </span>
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium 
                                        {{ $tribute->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                                        {{ $tribute->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                                        {{ $tribute->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : '' }}
                                    ">
                                        {{ ucfirst($tribute->status) }}
                                    </span>
                                </div>

                                {{-- Submitter Info --}}
                                <div class="mb-3">
                                    <p class="font-semibold text-slate-900 dark:text-white">{{ $tribute->submitter_name }}</p>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">{{ $tribute->submitter_email }}</p>
                                    @if($tribute->relationship)
                                        <p class="text-xs text-slate-500 dark:text-slate-500">{{ $tribute->relationship }}</p>
                                    @endif
                                </div>

                                {{-- Tribute Content --}}
                                @if($tribute->headline)
                                    <h3 class="mb-2 font-semibold text-slate-900 dark:text-white">{{ $tribute->headline }}</h3>
                                @endif
                                <p class="text-slate-700 dark:text-slate-300">{{ $tribute->message }}</p>
                            </div>

                            {{-- Actions --}}
                            @if($tribute->status === 'pending')
                                <div class="ml-4 flex flex-col gap-2">
                                    <button 
                                        wire:click="approveTribute('{{ $tribute->id }}')"
                                        wire:confirm="Are you sure you want to approve this tribute?"
                                        class="rounded-md bg-green-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-green-500"
                                    >
                                        Approve
                                    </button>
                                    <button 
                                        wire:click="rejectTribute('{{ $tribute->id }}')"
                                        wire:confirm="Are you sure you want to reject this tribute?"
                                        class="rounded-md bg-red-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-red-500"
                                    >
                                        Reject
                                    </button>
                                </div>
                            @endif
                        </div>

                        {{-- Moderation Info --}}
                        @if($tribute->moderated_by)
                            <div class="mt-4 border-t border-slate-200 pt-3 dark:border-slate-700">
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    Moderated by {{ $tribute->moderated_by }} 
                                    @if($tribute->approved_at)
                                        on {{ $tribute->approved_at->format('M d, Y \a\t g:i A') }}
                                    @elseif($tribute->rejected_at)
                                        on {{ $tribute->rejected_at->format('M d, Y \a\t g:i A') }}
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $tributes->links() }}
            </div>
        @endif
    </div>
</div>
