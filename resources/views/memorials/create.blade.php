<?php

use App\Mail\MemorialPublished;
use App\Models\MediaAsset;
use App\Models\Memorial;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;


#[Layout('layouts.app')]
#[Title('Create a Pet Memorial')]
new class extends Component
{
    use WithFileUploads;

    public int $step = 1;

    public array $form = [
        'owner_name' => '',
        'owner_email' => '',
        'pet_name' => '',
        'title' => '',
        'headline' => '',
        'summary' => '',
        'story' => '',
        'visibility' => 'private',
        'theme' => [
            'primary' => '#4f46e5',
            'accent' => '#f97316',
        ],
    ];

    public ?Memorial $memorial = null;

    public $heroUpload;

    /**
     * @var array<int, \Livewire\Features\SupportFileUploads\TemporaryUploadedFile>
     */
    public array $galleryUploads = [];

    protected function rules(): array
    {
        return [
            'form.owner_name' => ['nullable', 'string', 'max:120'],
            'form.owner_email' => ['required', 'email:rfc,dns', 'max:255'],
            'form.pet_name' => ['required', 'string', 'max:120'],
            'form.title' => ['required', 'string', 'max:160'],
            'form.headline' => ['nullable', 'string', 'max:180'],
            'form.summary' => ['nullable', 'string', 'max:400'],
            'form.story' => ['required', 'string', 'min:50'],
            'form.visibility' => ['required', 'in:private,unlisted,public'],
            'form.theme.primary' => ['required', 'string', 'size:7'],
            'form.theme.accent' => ['required', 'string', 'size:7'],
            'heroUpload' => ['nullable', 'image', 'max:5120'],
            'galleryUploads' => ['array', 'max:6'],
            'galleryUploads.*' => ['image', 'max:5120'],
        ];
    }

    public function stepRules(): array
    {
        return match ($this->step) {
            1 => Arr::only($this->rules(), ['form.owner_name', 'form.owner_email', 'form.pet_name', 'form.title']),
            2 => Arr::only($this->rules(), ['form.headline', 'form.summary', 'form.story']),
            3 => Arr::only($this->rules(), ['form.visibility', 'form.theme.primary', 'form.theme.accent', 'heroUpload', 'galleryUploads', 'galleryUploads.*']),
            default => $this->rules(),
        };
    }

    public function next(): void
    {
        $this->validate($this->stepRules());

        if ($this->step < 4) {
            $this->step++;
        }
    }

    public function back(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function submit(): void
    {
        $this->validate();

        $user = User::firstOrNew(['email' => $this->form['owner_email']]);
        $user->name = $this->form['owner_name'] ?: $user->name ?: 'Memorial Owner';

        if (! $user->exists) {
            $user->password = Hash::make(Str::random(32));
        }

        $user->save();
        Auth::login($user);

        $slug = $this->generateUniqueSlug();

        $heroPath = $this->heroUpload ? $this->heroUpload->store('memorial-heroes', 'public') : null;

        $status = $this->form['visibility'] === 'public' ? 'published' : 'draft';

        $memorial = Memorial::create([
            'owner_id' => $user->id,
            'title' => $this->form['title'],
            'slug' => $slug,
            'pet_name' => $this->form['pet_name'],
            'headline' => $this->form['headline'] ?: null,
            'summary' => $this->form['summary'] ?: null,
            'story' => $this->form['story'],
            'theme' => $this->form['theme'],
            'status' => $status,
            'visibility' => $this->form['visibility'],
            'hero_image_path' => $heroPath,
            'published_at' => $status === 'published' ? now() : null,
        ]);

        if ($heroPath) {
            MediaAsset::create([
                'memorial_id' => $memorial->id,
                'collection' => 'hero',
                'disk' => 'public',
                'path' => $heroPath,
                'thumbnail_path' => null,
                'type' => 'image',
                'sort_order' => 0,
            ]);
        }

        foreach ($this->galleryUploads as $index => $upload) {
            $path = $upload->store('memorial-gallery', 'public');

            MediaAsset::create([
                'memorial_id' => $memorial->id,
                'collection' => 'gallery',
                'disk' => 'public',
                'path' => $path,
                'thumbnail_path' => null,
                'type' => 'image',
                'sort_order' => $index + 1,
            ]);
        }

        $this->memorial = $memorial;

        session()->flash('memorial.created', true);

        $this->redirectRoute('memorials.show', $memorial);
    }

    protected function generateUniqueSlug(): string
    {
        $base = Str::slug($this->form['pet_name']);

        if ($base === '') {
            $base = Str::slug($this->form['title']);
        }

        if ($base === '') {
            $base = Str::lower(Str::random(6));
        }

        $slug = $base;
        $counter = 1;

        while (Memorial::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function with(): array
    {
        return [
            'steps' => [
                1 => 'Companion',
                2 => 'Story',
                3 => 'Design',
                4 => 'Preview',
            ],
            'visibilityOptions' => [
                'private' => 'Private (invite only)',
                'unlisted' => 'Unlisted (shareable link)',
                'public' => 'Public (searchable)',
            ],
        ];
    }
};
?>

<section class="bg-slate-100 py-16 dark:bg-slate-950">
    <div class="mx-auto max-w-5xl px-6">
        <header class="text-center">
            <p class="text-sm font-semibold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Guided memorial builder</p>
            <h1 class="mt-4 text-4xl font-semibold text-slate-900 dark:text-white">Craft a space for {{ $form['pet_name'] ?: 'your companion' }}</h1>
            <p class="mt-3 text-slate-600 dark:text-slate-300">We'll walk you through a few quick steps. You can update everything later.</p>
        </header>

        <nav class="mt-10 flex justify-center">
            <ol class="flex items-center gap-3 text-sm font-medium text-slate-500 dark:text-slate-400">
                @foreach ($steps as $index => $label)
                    <li class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full {{ $step >= $index ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-600 dark:bg-slate-800 dark:text-slate-300' }}">{{ $index }}</span>
                        <span class="hidden sm:inline">{{ $label }}</span>
                        @if ($index < 4)
                            <span class="text-slate-400 dark:text-slate-600">?</span>
                        @endif
                    </li>
                @endforeach
            </ol>
        </nav>

        <div class="mt-12 rounded-3xl border border-slate-200 bg-white p-10 shadow-xl dark:border-slate-800 dark:bg-slate-900">
            <form wire:submit="submit" class="space-y-10">
                @if ($step === 1)
                    <div class="grid gap-6 sm:grid-cols-2">
                        <label>
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Your name</span>
                            <input wire:model.live="form.owner_name" type="text" placeholder="Alex Rivera" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white">
                            @error('form.owner_name')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                        </label>
                        <label>
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Email<span class="text-rose-500">*</span></span>
                            <input wire:model.live="form.owner_email" type="email" placeholder="you@example.com" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white">
                            @error('form.owner_email')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                        </label>
                        <label class="sm:col-span-1">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Pet name<span class="text-rose-500">*</span></span>
                            <input wire:model.live="form.pet_name" type="text" placeholder="Pepper" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white">
                            @error('form.pet_name')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                        </label>
                        <label class="sm:col-span-1">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Memorial title<span class="text-rose-500">*</span></span>
                            <input wire:model.live="form.title" type="text" placeholder="Pepper's Adventure" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white">
                            @error('form.title')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                        </label>
                    </div>
                @elseif ($step === 2)
                    <div class="space-y-6">
                        <label>
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Headline</span>
                            <input wire:model.live="form.headline" type="text" placeholder="A gentle soul who filled every day with sunshine" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white">
                            @error('form.headline')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                        </label>
                        <label>
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Short summary</span>
                            <textarea wire:model.live="form.summary" rows="3" placeholder="Introduce friends and family to this memorial..." class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white"></textarea>
                            @error('form.summary')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                        </label>
                        <label>
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Story<span class="text-rose-500">*</span></span>
                            <textarea wire:model.live="form.story" rows="8" placeholder="Share favorite memories, how you met, and the little quirks you loved..." class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white"></textarea>
                            @error('form.story')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                        </label>
                    </div>
                @elseif ($step === 3)
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="space-y-4">
                            <label class="block">
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Visibility</span>
                                <select wire:model.live="form.visibility" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white">
                                    @foreach ($visibilityOptions as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('form.visibility')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="block">
                                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Primary color</span>
                                    <input wire:model.live="form.theme.primary" type="color" class="mt-2 h-12 w-full rounded-2xl border border-slate-300 bg-white dark:border-slate-700 dark:bg-slate-950">
                                    @error('form.theme.primary')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                                </label>
                                <label class="block">
                                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Accent color</span>
                                    <input wire:model.live="form.theme.accent" type="color" class="mt-2 h-12 w-full rounded-2xl border border-slate-300 bg-white dark:border-slate-700 dark:bg-slate-950">
                                    @error('form.theme.accent')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                                </label>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <label class="block">
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Hero image</span>
                                <input wire:model="heroUpload" type="file" accept="image/*" class="mt-2 block w-full text-sm text-slate-600 file:mr-4 file:rounded-full file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100 dark:text-slate-300 dark:file:bg-indigo-500/10 dark:file:text-indigo-200">
                                @error('heroUpload')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                                @if ($heroUpload)
                                    <img src="{{ $heroUpload->temporaryUrl() }}" alt="Hero preview" class="mt-4 h-40 w-full rounded-2xl object-cover">
                                @endif
                            </label>
                            <label class="block">
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Gallery photos (optional)</span>
                                <input wire:model="galleryUploads" type="file" multiple accept="image/*" class="mt-2 block w-full text-sm text-slate-600 file:mr-4 file:rounded-full file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100 dark:text-slate-300 dark:file:bg-indigo-500/10 dark:file:text-indigo-200">
                                @error('galleryUploads')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                                @error('galleryUploads.*')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                                @if ($galleryUploads)
                                    <div class="mt-4 grid grid-cols-3 gap-2">
                                        @foreach ($galleryUploads as $upload)
                                            <img src="{{ $upload->temporaryUrl() }}" alt="Gallery preview" class="h-24 w-full rounded-xl object-cover">
                                        @endforeach
                                    </div>
                                @endif
                            </label>
                        </div>
                    </div>
                @elseif ($step === 4)
                    <div class="grid gap-8 md:grid-cols-2">
                        <div class="space-y-4 rounded-2xl border border-slate-200 bg-slate-50 p-6 dark:border-slate-800 dark:bg-slate-950">
                            <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Memorial snapshot</h2>
                            <p class="text-sm text-slate-600 dark:text-slate-300">Double-check the details before publishing. You can edit anytime.</p>
                            <dl class="space-y-2 text-sm text-slate-700 dark:text-slate-300">
                                <div>
                                    <dt class="font-semibold text-slate-900 dark:text-white">Title</dt>
                                    <dd>{{ $form['title'] }}</dd>
                                </div>
                                <div>
                                    <dt class="font-semibold text-slate-900 dark:text-white">Pet name</dt>
                                    <dd>{{ $form['pet_name'] }}</dd>
                                </div>
                                <div>
                                    <dt class="font-semibold text-slate-900 dark:text-white">Headline</dt>
                                    <dd>{{ $form['headline'] ?: '—' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-semibold text-slate-900 dark:text-white">Visibility</dt>
                                    <dd>{{ $visibilityOptions[$form['visibility']] }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div class="space-y-4 rounded-2xl border border-slate-200 bg-slate-50 p-6 dark:border-slate-800 dark:bg-slate-950">
                            <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Story preview</h2>
                            <p class="text-sm leading-relaxed text-slate-700 dark:text-slate-300 whitespace-pre-line">{{ Str::limit($form['story'], 800) }}</p>
                            <div class="flex gap-4 text-sm">
                                <div>
                                    <span class="block text-xs uppercase tracking-wide text-slate-500">Primary</span>
                                    <span class="mt-1 block h-6 w-20 rounded-full border border-slate-200" style="background-color: {{ $form['theme']['primary'] }}"></span>
                                </div>
                                <div>
                                    <span class="block text-xs uppercase tracking-wide text-slate-500">Accent</span>
                                    <span class="mt-1 block h-6 w-20 rounded-full border border-slate-200" style="background-color: {{ $form['theme']['accent'] }}"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex flex-col gap-3 border-t border-slate-200 pt-6 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-sm text-slate-500 dark:text-slate-400">
                        Step {{ $step }} of 4
                    </div>
                    <div class="flex flex-col gap-3 sm:flex-row">
                        @if ($step > 1)
                            <button type="button" wire:click="back" class="inline-flex items-center justify-center rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-indigo-200 hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:border-slate-700 dark:text-slate-200">
                                Back
                            </button>
                        @endif
                        @if ($step < 4)
                            <button type="button" wire:click="next" class="inline-flex items-center justify-center rounded-full bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Continue
                            </button>
                        @else
                            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600" wire:loading.attr="disabled">
                                <span wire:loading.remove>Publish memorial</span>
                                <span wire:loading class="inline-flex items-center gap-2">
                                    <svg class="h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3.5-3.5L12 0v4a8 8 0 00-8 8h4z"></path></svg>
                                        Saving...
                                </span>
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
