<?php

use App\Models\MediaAsset;
use App\Models\Memorial;
use App\Models\Tribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

#[Layout('layouts.app')]
new class extends Component
{
    public Memorial $memorial;

    public string $tribute_name = '';

    public string $tribute_email = '';

    public string $tribute_relationship = '';

    public string $tribute_message = '';

    public bool $tributeSubmitted = false;

    public function mount(Memorial $memorial): void
    {
        $this->memorial = $memorial->load([
            'approvedTributes' => fn ($query) => $query->latest('published_at'),
            'mediaAssets',
        ]);
    }

    protected function rules(): array
    {
        return [
            'tribute_name' => ['required', 'string', 'max:120'],
            'tribute_email' => ['nullable', 'email:rfc,dns', 'max:255'],
            'tribute_relationship' => ['nullable', 'string', 'max:120'],
            'tribute_message' => ['required', 'string', 'min:10', 'max:1000'],
        ];
    }

    public function submitTribute(): void
    {
        $this->validate();

        Tribute::create([
            'memorial_id' => $this->memorial->id,
            'submitter_name' => $this->tribute_name,
            'submitter_email' => $this->tribute_email ?: null,
            'relationship' => $this->tribute_relationship ?: null,
            'message' => $this->tribute_message,
            'status' => 'pending',
        ]);

        $this->reset(['tribute_name', 'tribute_email', 'tribute_relationship', 'tribute_message']);
        $this->tributeSubmitted = true;
    }

    public function heroUrl(): ?string
    {
        if (! $this->memorial->hero_image_path) {
            return null;
        }

        return Storage::disk('public')->url($this->memorial->hero_image_path);
    }

    /**
     * @return array<int, MediaAsset>
     */
    public function gallery(): array
    {
        return $this->memorial->mediaAssets->where('collection', 'gallery')->sortBy('sort_order')->values()->all();
    }

    public function with(): array
    {
        $theme = $this->memorial->theme ?? ['primary' => '#4f46e5', 'accent' => '#f97316'];

        return [
            'title' => $this->memorial->title . ' — FourPaws Studio',
            'metaDescription' => $this->memorial->summary ?? Str::limit(strip_tags($this->memorial->story), 160),
            'ogImage' => $this->heroUrl(),
            'theme' => $theme,
            'heroUrl' => $this->heroUrl(),
            'gallery' => $this->gallery(),
        ];
    }
};
?>

@php
    $primary = $theme['primary'] ?? '#4f46e5';
    $accent = $theme['accent'] ?? '#f97316';
    $gradient = "background-image: radial-gradient(circle at top, {$primary}, {$accent});";
@endphp

<section class="relative overflow-hidden bg-slate-950 text-white" style="{{ $gradient }}">
    <div class="absolute inset-0 bg-slate-950/60"></div>
    <div class="relative mx-auto flex max-w-6xl flex-col gap-10 px-6 py-20 lg:flex-row lg:items-center">
        <div class="w-full lg:w-3/5">
            <p class="text-sm font-semibold uppercase tracking-widest text-white/70">In loving memory of {{ $memorial->pet_name }}</p>
            <h1 class="mt-4 text-4xl font-semibold leading-tight sm:text-5xl">{{ $memorial->title }}</h1>
            <p class="mt-6 max-w-2xl text-lg text-white/80">{{ $memorial->headline ?? 'A memorial crafted with love on FourPaws Studio.' }}</p>
            <div class="mt-8 flex flex-wrap items-center gap-6 text-sm text-white/70">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-2">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    {{ Str::headline($memorial->visibility) }} memorial
                </span>
                <span>{{ $memorial->approvedTributes->count() }} tributes</span>
                <span>Launched {{ optional($memorial->published_at ?? $memorial->created_at)->diffForHumans() }}</span>
            </div>
        </div>
        <div class="w-full lg:w-2/5">
            @if ($heroUrl)
                <img src="{{ $heroUrl }}" alt="{{ $memorial->pet_name }} hero" class="h-72 w-full rounded-3xl object-cover ring-2 ring-white/40">
            @else
                <div class="flex h-72 w-full items-center justify-center rounded-3xl border-2 border-dashed border-white/40 text-white/60">
                    Add a hero photo to make this banner shine.
                </div>
            @endif
        </div>
    </div>
</section>

<section class="bg-white py-16 dark:bg-slate-950">
    <div class="mx-auto grid max-w-6xl gap-12 px-6 lg:grid-cols-[2fr,1fr]">
        <article class="space-y-8 text-slate-700 dark:text-slate-200">
            @if ($memorial->summary)
                <p class="text-lg leading-relaxed text-slate-600 dark:text-slate-300">{{ $memorial->summary }}</p>
            @endif
            <div class="prose max-w-none text-slate-700 prose-headings:text-slate-900 prose-a:text-indigo-600 dark:prose-invert dark:prose-headings:text-white">
                {!! nl2br(e($memorial->story)) !!}
            </div>

            @if (count($gallery))
                <section class="mt-8">
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Gallery</h2>
                    <div class="mt-4 grid grid-cols-2 gap-4 md:grid-cols-3">
                        @foreach ($gallery as $asset)
                            <figure class="overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-800">
                                <img src="{{ Storage::disk($asset->disk)->url($asset->path) }}" alt="{{ $asset->meta['alt'] ?? $memorial->pet_name }} photo" class="h-44 w-full object-cover transition hover:scale-105">
                            </figure>
                        @endforeach
                    </div>
                </section>
            @endif

            <section class="mt-12">
                <header class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Tributes</h2>
                    <span class="text-sm text-slate-500 dark:text-slate-400">{{ $memorial->approvedTributes->count() }} shared memories</span>
                </header>
                <div class="mt-4 grid gap-4">
                    @forelse ($memorial->approvedTributes as $tribute)
                        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                            <header class="flex items-center justify-between text-sm text-slate-500 dark:text-slate-400">
                                <span class="font-semibold text-slate-900 dark:text-white">{{ $tribute->submitter_name }}</span>
                                <time datetime="{{ optional($tribute->published_at)->toDateString() }}">{{ optional($tribute->published_at ?? $tribute->created_at)->diffForHumans() }}</time>
                            </header>
                            <p class="mt-3 text-sm leading-relaxed text-slate-700 dark:text-slate-200">{{ $tribute->message }}</p>
                            @if ($tribute->relationship)
                                <p class="mt-3 text-xs uppercase tracking-wide text-slate-400 dark:text-slate-500">{{ $tribute->relationship }}</p>
                            @endif
                        </article>
                    @empty
                        <p class="rounded-3xl border border-dashed border-slate-200 p-6 text-sm text-slate-500 dark:border-slate-800 dark:text-slate-400">No tributes yet. Be the first to share a memory.</p>
                    @endforelse
                </div>
            </section>
        </article>

        <aside class="space-y-6 rounded-3xl border border-slate-200 bg-slate-50 p-6 dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Share a tribute</h2>
            <p class="text-sm text-slate-600 dark:text-slate-300">Your message will appear once the memorial host approves it.</p>

            @if ($tributeSubmitted)
                <div class="rounded-2xl bg-emerald-100 px-4 py-3 text-sm text-emerald-800 dark:bg-emerald-500/10 dark:text-emerald-200">
                    Thank you for sharing a memory! Once approved it will appear here.
                </div>
            @endif

            <form wire:submit="submitTribute" class="space-y-4">
                <label class="block">
                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Name<span class="text-rose-500">*</span></span>
                    <input wire:model.live="tribute_name" type="text" placeholder="Your name" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-900 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white">
                    @error('tribute_name')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                </label>
                <label class="block">
                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Email</span>
                    <input wire:model.live="tribute_email" type="email" placeholder="Optional" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-900 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white">
                    @error('tribute_email')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                </label>
                <label class="block">
                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Relationship</span>
                    <input wire:model.live="tribute_relationship" type="text" placeholder="Friend, family, vet..." class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-900 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white">
                    @error('tribute_relationship')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                </label>
                <label class="block">
                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Message<span class="text-rose-500">*</span></span>
                    <textarea wire:model.live="tribute_message" rows="5" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-900 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white" placeholder="Share your favorite memory..."></textarea>
                    @error('tribute_message')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                </label>
                <button type="submit" class="w-full rounded-full bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" wire:loading.attr="disabled">
                    <span wire:loading.remove>Send tribute</span>
                    <span wire:loading class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3.5-3.5L12 0v4a8 8 0 00-8 8h4z"></path></svg>
                        Sending...
                    </span>
                </button>
            </form>
        </aside>
    </div>
</section>
