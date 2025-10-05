<div class="min-h-screen bg-slate-50 dark:bg-slate-900">
    {{-- Hero Section --}}
    <div class="relative overflow-hidden bg-{{ $memorial->theme['color'] ?? 'indigo' }}-600 py-24">
        <div class="absolute inset-0">
            <img 
                src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=1600&h=400&fit=crop&q=80" 
                alt="Memorial background" 
                class="h-full w-full object-cover opacity-20"
            >
        </div>
        <div class="relative mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                {{ $memorial->companion_name }}
            </h1>
            <p class="mt-4 text-xl text-white/90">
                {{ $memorial->species }}
                @if($memorial->breed)
                    • {{ $memorial->breed }}
                @endif
            </p>
            @if($memorial->date_of_birth || $memorial->date_of_passing)
                <p class="mt-2 text-lg text-white/80">
                    @if($memorial->date_of_birth)
                        {{ \Carbon\Carbon::parse($memorial->date_of_birth)->format('M d, Y') }}
                    @endif
                    @if($memorial->date_of_birth && $memorial->date_of_passing)
                        —
                    @endif
                    @if($memorial->date_of_passing)
                        {{ \Carbon\Carbon::parse($memorial->date_of_passing)->format('M d, Y') }}
                    @endif
                </p>
            @endif
        </div>
    </div>

    {{-- Photo Gallery Section --}}
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            <div class="aspect-square overflow-hidden rounded-lg">
                <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=400&h=400&fit=crop&q=80" alt="Pet photo" class="h-full w-full object-cover">
            </div>
            <div class="aspect-square overflow-hidden rounded-lg">
                <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=400&h=400&fit=crop&q=80" alt="Pet photo" class="h-full w-full object-cover">
            </div>
            <div class="aspect-square overflow-hidden rounded-lg">
                <img src="https://images.unsplash.com/photo-1530281700549-e82e7bf110d6?w=400&h=400&fit=crop&q=80" alt="Pet photo" class="h-full w-full object-cover">
            </div>
            <div class="aspect-square overflow-hidden rounded-lg">
                <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=400&h=400&fit=crop&q=80" alt="Pet photo" class="h-full w-full object-cover">
            </div>
        </div>
    </section>

    {{-- Biography Section --}}
    @if($memorial->biography)
        <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-8 shadow dark:bg-slate-800">
                <h2 class="mb-4 text-2xl font-bold text-slate-900 dark:text-white">Their Story</h2>
                <div class="prose prose-slate max-w-none dark:prose-invert">
                    <p class="whitespace-pre-wrap text-slate-700 dark:text-slate-300">{{ $memorial->biography }}</p>
                </div>
            </div>
        </section>
    @endif

    {{-- Tributes Section --}}
    <section class="bg-white py-16 dark:bg-slate-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Tributes & Memories</h2>
                <p class="mt-2 text-lg text-slate-600 dark:text-slate-400">
                    Share your favorite memories of {{ $memorial->companion_name }}
                </p>
            </div>

            {{-- Tribute Submission Form --}}
            @if(($memorial->settings['allow_tributes'] ?? true))
                <div class="mx-auto mt-12 max-w-2xl">
                    <div class="rounded-lg bg-slate-50 p-6 dark:bg-slate-900">
                        @if($tributeSubmitted)
                            <div class="rounded-md bg-green-50 p-4 dark:bg-green-900/20">
                                <div class="flex">
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-800 dark:text-green-300">
                                            Thank you for your tribute! 
                                            @if(($memorial->settings['moderate_tributes'] ?? true))
                                                It will appear after review.
                                            @else
                                                It has been posted.
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <form wire:submit="submitTribute" class="space-y-4">
                                <div>
                                    <label for="tributeAuthorName" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                                        Your Name <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        wire:model="tributeAuthorName" 
                                        type="text" 
                                        id="tributeAuthorName" 
                                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-600 dark:bg-slate-800 dark:text-white sm:text-sm"
                                        required
                                    >
                                    @error('tributeAuthorName') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="tributeAuthorEmail" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                                        Your Email <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        wire:model="tributeAuthorEmail" 
                                        type="email" 
                                        id="tributeAuthorEmail" 
                                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-600 dark:bg-slate-800 dark:text-white sm:text-sm"
                                        required
                                    >
                                    @error('tributeAuthorEmail') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="tributeMessage" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                                        Your Message <span class="text-red-500">*</span>
                                    </label>
                                    <textarea 
                                        wire:model="tributeMessage" 
                                        id="tributeMessage" 
                                        rows="4" 
                                        class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-600 dark:bg-slate-800 dark:text-white sm:text-sm"
                                        placeholder="Share your favorite memory or message..."
                                        required
                                    ></textarea>
                                    @error('tributeMessage') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                                </div>

                                <button 
                                    type="submit" 
                                    class="w-full rounded-md bg-{{ $memorial->theme['color'] ?? 'indigo' }}-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-{{ $memorial->theme['color'] ?? 'indigo' }}-500"
                                >
                                    Share Your Tribute
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Tributes List --}}
            @if($tributes->count() > 0)
                <div class="mx-auto mt-12 max-w-4xl">
                    <div class="space-y-6">
                        @foreach($tributes as $tribute)
                            <div class="rounded-lg bg-white p-6 shadow dark:bg-slate-800">
                                <div class="flex items-start gap-4">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-{{ $memorial->theme['color'] ?? 'indigo' }}-100 dark:bg-{{ $memorial->theme['color'] ?? 'indigo' }}-900/30">
                                        <span class="text-sm font-semibold text-{{ $memorial->theme['color'] ?? 'indigo' }}-600 dark:text-{{ $memorial->theme['color'] ?? 'indigo' }}-400">
                                            {{ substr($tribute->author_name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-sm font-semibold text-slate-900 dark:text-white">{{ $tribute->author_name }}</h3>
                                            <time class="text-xs text-slate-500 dark:text-slate-400">{{ $tribute->created_at->diffForHumans() }}</time>
                                        </div>
                                        <p class="mt-2 whitespace-pre-wrap text-sm text-slate-700 dark:text-slate-300">{{ $tribute->message }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
