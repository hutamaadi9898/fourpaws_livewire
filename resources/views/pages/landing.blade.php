<?php

use App\Jobs\SyncWaitlistSignup;
use App\Models\WaitlistSignup;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

#[Layout('layouts.app')]
#[Title('FourPaws Studio — Pet Memorials That Last Forever')]
new class extends Component
{
    public string $name = '';

    public string $email = '';

    public string $message = '';

    public bool $submitted = false;

    protected function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'message' => ['nullable', 'string', 'max:500'],
        ];
    }


    public function submit(): void
    {
        $this->validate();

        $waitlistSignup = WaitlistSignup::updateOrCreate(
            ['email' => $this->email],
            [
                'name' => $this->name,
                'source' => 'landing',
                'meta' => array_filter([
                    'message' => $this->message ?: null,
                    'utm' => request()->query('utm_source'),
                ]),
            ]
        );

        SyncWaitlistSignup::dispatch($waitlistSignup->id);

        $this->reset(['name', 'email', 'message']);
        $this->submitted = true;
    }

    public function with(): array
    {
        return [
            'featureCards' => [
                [
                    'title' => 'Share Their Story',
                    'description' => 'Build a beautiful, media-rich tribute that captures every milestone and memory.',
                    'icon' => '??',
                ],
                [
                    'title' => 'Invite Loved Ones',
                    'description' => 'Gather tributes, photos, and voice notes from friends and family in one safe place.',
                    'icon' => '??',
                ],
                [
                    'title' => 'Custom Subdomain',
                    'description' => 'Claim a dedicated space like fourpaws.studio/anne or connect your own domain.',
                    'icon' => '??',
                ],
            ],
            'testimonials' => [
                [
                    'quote' => 'Creating Pepper\'s memorial helped us heal together as a family. The guided steps made it effortless.',
                    'name' => 'Jasmine & Milo',
                ],
                [
                    'quote' => 'The tribute submissions from friends around the world were the most comforting surprise.',
                    'name' => 'Avery L.',
                ],
            ],
            'faqs' => [
                [
                    'question' => 'How quickly can I launch a memorial?',
                    'answer' => 'Most pet parents publish within 15 minutes. You can always update the story, photos, and theme later.',
                ],
                [
                    'question' => 'Can I keep the memorial private?',
                    'answer' => 'Yes. Choose between private, unlisted, and public visibility with invite-only tributes.',
                ],
                [
                    'question' => 'Do you support custom domains?',
                    'answer' => 'Custom domains arrive with the public launch. Join the waitlist for early access.',
                ],
            ],
        ];
    }
};
?>

<section class="relative overflow-hidden bg-gradient-to-b from-indigo-100 via-white to-white dark:from-slate-900 dark:via-slate-950 dark:to-slate-950">
    <div class="mx-auto flex w-full max-w-6xl flex-col gap-16 px-6 py-24 lg:flex-row lg:items-center lg:py-32">
        <div class="w-full lg:w-1/2">
            <span class="inline-flex items-center rounded-full bg-indigo-100 px-4 py-1 text-sm font-medium text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-200">
                Crafted for cherished companions
            </span>
            <h1 class="mt-6 text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl dark:text-white">
                Celebrate your pet's life with a living memorial
            </h1>
            <p class="mt-6 text-lg text-slate-600 dark:text-slate-300">
                FourPaws Studio helps you spin up a stunning memorial in minutes. Capture memories, gather tributes, and share on your own branded page.
            </p>
            <div class="mt-10 flex flex-col gap-4 sm:flex-row">
                <a href="#waitlist" class="inline-flex items-center justify-center rounded-full bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Join the private beta
                </a>
                <a href="#features" class="inline-flex items-center justify-center rounded-full border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-indigo-200 hover:text-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:border-slate-700 dark:text-slate-200">
                    Explore features
                </a>
            </div>
            <dl class="mt-10 grid grid-cols-2 gap-6 text-sm text-slate-600 dark:text-slate-300 sm:grid-cols-3">
                <div>
                    <dt class="font-medium text-slate-900 dark:text-white">Memorials published</dt>
                    <dd class="mt-1 text-2xl font-semibold text-indigo-600 dark:text-indigo-400">1,200+</dd>
                </div>
                <div>
                    <dt class="font-medium text-slate-900 dark:text-white">Tributes shared</dt>
                    <dd class="mt-1 text-2xl font-semibold text-indigo-600 dark:text-indigo-400">8,500+</dd>
                </div>
                <div>
                    <dt class="font-medium text-slate-900 dark:text-white">Average setup time</dt>
                    <dd class="mt-1 text-2xl font-semibold text-indigo-600 dark:text-indigo-400">12 min</dd>
                </div>
            </dl>
        </div>
        <div class="relative w-full lg:w-1/2">
            <div class="absolute -left-6 -top-6 h-72 w-72 rounded-full bg-indigo-200/60 blur-3xl dark:bg-indigo-500/20"></div>
            <div class="relative overflow-hidden rounded-3xl border border-indigo-100 bg-white p-8 shadow-xl shadow-indigo-200/20 dark:border-slate-800 dark:bg-slate-900">
                <div class="grid gap-4 text-sm">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-600 text-white">FP</span>
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">Ginger's Story</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">ginger.fourpaws.studio</p>
                        </div>
                    </div>
                    <p class="text-base leading-relaxed text-slate-600 dark:text-slate-300">
                        “Ginger taught us unconditional love. FourPaws made it possible to honor every tail wag and adventure. Friends sent tributes with memories we forgot existed.”
                    </p>
                    <div class="flex items-center gap-6 text-xs text-slate-500 dark:text-slate-400">
                        <div class="flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                            Live memorial
                        </div>
                        <div>24 tributes • 86 photos</div>
                    </div>
                </div>
                <div class="mt-6 grid grid-cols-3 gap-2">
                    <div class="col-span-2 overflow-hidden rounded-2xl bg-slate-100 dark:bg-slate-800">
                        <img src="https://images.unsplash.com/photo-1557973765-3f2430c1f52b?auto=format&fit=crop&w=1200&q=80" alt="Pet collage" class="h-full w-full object-cover">
                    </div>
                    <div class="grid gap-2">
                        <img src="https://images.unsplash.com/photo-1530281700549-e82e7bf110d6?auto=format&fit=crop&w=600&q=80" alt="Pet portrait" class="h-full w-full rounded-2xl object-cover">
                        <img src="https://images.unsplash.com/photo-1505628346881-b72b27e84530?auto=format&fit=crop&w=600&q=80" alt="Pet with owner" class="h-full w-full rounded-2xl object-cover">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="features" class="bg-white py-20 dark:bg-slate-950">
    <div class="mx-auto max-w-6xl px-6">
        <div class="max-w-2xl">
            <h2 class="text-3xl font-semibold text-slate-900 dark:text-white">Design a memorial as unique as your companion</h2>
            <p class="mt-4 text-lg text-slate-600 dark:text-slate-300">Guided steps, customizable themes, and gentle prompts help you craft a story worth sharing.</p>
        </div>
        <div class="mt-12 grid gap-10 md:grid-cols-3">
            @foreach ($featureCards as $feature)
                <article class="group rounded-3xl border border-slate-200/60 bg-white p-8 shadow-lg shadow-slate-200/40 transition hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 text-2xl dark:bg-indigo-500/20">
                        {{ $feature['icon'] }}
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-slate-900 dark:text-white">{{ $feature['title'] }}</h3>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-300">{{ $feature['description'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-slate-950 py-20 text-white dark:bg-black">
    <div class="mx-auto max-w-6xl px-6">
        <div class="grid gap-12 lg:grid-cols-3">
            <div>
                <h2 class="text-3xl font-semibold">Loved by remembrance communities</h2>
                <p class="mt-4 text-slate-300">We work closely with grief counselors and veterinarians to craft compassionate experiences.</p>
            </div>
            <div class="lg:col-span-2">
                <div class="grid gap-6 sm:grid-cols-2">
                    @foreach ($testimonials as $testimonial)
                        <blockquote class="rounded-3xl bg-white/5 p-6 text-sm leading-relaxed text-slate-200 ring-1 ring-white/10">
                            “{{ $testimonial['quote'] }}”
                            <footer class="mt-4 text-xs font-semibold uppercase tracking-wide text-indigo-200">{{ $testimonial['name'] }}</footer>
                        </blockquote>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section id="waitlist" class="bg-white py-20 dark:bg-slate-950">
    <div class="mx-auto max-w-3xl rounded-3xl border border-slate-200/80 bg-slate-50 p-10 shadow-xl shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
        <h2 class="text-3xl font-semibold text-slate-900 dark:text-white">Join the private beta</h2>
        <p class="mt-3 text-slate-600 dark:text-slate-300">Be the first to launch your pet's memorial, access exclusive templates, and shape upcoming features.</p>

        @if ($submitted)
            <div class="mt-6 rounded-2xl bg-emerald-100 px-4 py-3 text-sm font-medium text-emerald-800 dark:bg-emerald-500/10 dark:text-emerald-200">
                Thank you! We'll be in touch soon with early access instructions.
            </div>
        @endif

        <form wire:submit="submit" class="mt-6 grid gap-4 sm:grid-cols-2">
            <label class="sm:col-span-1">
                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Name</span>
                <input wire:model.live="name" type="text" placeholder="Your name" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white">
                @error('name')
                    <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </label>
            <label class="sm:col-span-1">
                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Email<span class="text-rose-500">*</span></span>
                <input wire:model.live="email" type="email" placeholder="you@example.com" class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white">
                @error('email')
                    <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </label>
            <label class="sm:col-span-2">
                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">How can we help?</span>
                <textarea wire:model.live="message" rows="4" placeholder="Tell us about your companion or what you're hoping to build..." class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white"></textarea>
                @error('message')
                    <p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </label>
            <div class="sm:col-span-2">
                <button type="submit" class="w-full rounded-full bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" wire:loading.attr="disabled">
                    <span wire:loading.remove>Request early access</span>
                    <span wire:loading class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3.5-3.5L12 0v4a8 8 0 00-8 8h4z"></path></svg>
                        Sending...
                    </span>
                </button>
            </div>
        </form>
    </div>
</section>

<section class="bg-slate-100 py-20 dark:bg-slate-900">
    <div class="mx-auto max-w-5xl px-6">
        <h2 class="text-3xl font-semibold text-slate-900 dark:text-white">Questions, answered</h2>
        <div class="mt-8 space-y-4">
            @foreach ($faqs as $faq)
                <details class="group rounded-2xl border border-slate-200 bg-white p-6 transition dark:border-slate-800 dark:bg-slate-950">
                    <summary class="flex cursor-pointer items-center justify-between text-lg font-semibold text-slate-900 marker:hidden dark:text-white">
                        <span>{{ $faq['question'] }}</span>
                        <span class="ml-4 inline-flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-indigo-600 transition group-open:rotate-45 dark:bg-indigo-500/20 dark:text-indigo-300">+</span>
                    </summary>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-300">{{ $faq['answer'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

<footer class="bg-slate-950 py-12 text-slate-400 dark:bg-black">
    <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-6 px-6 text-sm sm:flex-row">
        <div class="text-slate-300">© {{ now()->year }} FourPaws Studio. All rights reserved.</div>
        <nav class="flex items-center gap-6">
            <a href="/privacy" class="hover:text-white">Privacy</a>
            <a href="/terms" class="hover:text-white">Terms</a>
            <a href="mailto:hello@fourpaws.studio" class="hover:text-white">Contact</a>
        </nav>
    </div>
</footer>
