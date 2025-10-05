<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('My Memorials') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @php
                $memorials = auth()->user()->memorials()->latest()->get();
            @endphp

            @if($memorials->isEmpty())
                {{-- Empty State --}}
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">No memorials yet</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Get started by creating a beautiful memorial for your beloved companion.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('memorials.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Create Memorial
                            </a>
                        </div>
                    </div>
                </div>
            @else
                {{-- Memorials Grid --}}
                <div class="mb-6 flex items-center justify-between">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $memorials->count() }} {{ Str::plural('memorial', $memorials->count()) }}
                    </p>
                    <a href="{{ route('memorials.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        New Memorial
                    </a>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($memorials as $memorial)
                        <div class="group relative overflow-hidden rounded-lg bg-white shadow transition hover:shadow-lg dark:bg-gray-800">
                            {{-- Image/Color Banner --}}
                            <div class="h-32 bg-gradient-to-br from-{{ $memorial->theme['color'] ?? 'indigo' }}-400 to-{{ $memorial->theme['color'] ?? 'indigo' }}-600"></div>
                            
                            {{-- Content --}}
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $memorial->pet_name }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $memorial->species }}
                                    @if($memorial->breed)
                                        • {{ $memorial->breed }}
                                    @endif
                                </p>
                                
                                @if($memorial->date_of_birth || $memorial->date_of_passing)
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-500">
                                        @if($memorial->date_of_birth && $memorial->date_of_passing)
                                            {{ $memorial->date_of_birth->format('M Y') }} - 
                                            {{ $memorial->date_of_passing->format('M Y') }}
                                        @elseif($memorial->date_of_passing)
                                            {{ $memorial->date_of_passing->format('M d, Y') }}
                                        @endif
                                    </p>
                                @endif

                                <div class="mt-4 flex items-center justify-between">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $memorial->visibility === 'public' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                        {{ $memorial->visibility === 'public' ? 'Public' : 'Private' }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $memorial->tributes()->where('status', 'approved')->count() }} tributes
                                    </span>
                                </div>

                                <div class="mt-4 flex gap-2">
                                    <a href="{{ route('memorials.show', $memorial->slug) }}" class="flex-1 rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                        View
                                    </a>
                                    <a href="{{ route('memorials.edit', $memorial) }}" class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
