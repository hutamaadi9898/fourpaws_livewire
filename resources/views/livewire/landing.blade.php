<div>
    {{-- Hero Section --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-indigo-100 via-white to-white dark:from-slate-900 dark:via-slate-950 dark:to-slate-950">
        <div class="mx-auto flex w-full max-w-6xl flex-col gap-16 px-6 py-24 lg:flex-row lg:items-center lg:py-32">
            <div class="w-full lg:w-1/2">
                <span class="inline-flex items-center rounded-full bg-indigo-100 px-4 py-1 text-sm font-medium text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-200">
                    🐾 Forever remembered, forever loved
                </span>
                <h1 class="mt-6 text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl lg:text-6xl dark:text-white">
                    Create a lasting tribute to your beloved pet
                </h1>
                <p class="mt-6 text-xl leading-8 text-slate-600 dark:text-slate-400">
                    Build a beautiful memorial page where you can share their story, preserve precious memories, and let friends and family celebrate the joy they brought into your life.
                </p>
                <div class="mt-10 flex flex-col items-start gap-4 sm:flex-row sm:items-center sm:gap-6">
                    @auth
                        <a href="{{ route('memorials.create') }}" class="w-full rounded-md bg-indigo-600 px-5 py-3 text-center text-base font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:w-auto">
                            Create Memorial
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="w-full rounded-md bg-indigo-600 px-5 py-3 text-center text-base font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:w-auto">
                            Get Started Free
                        </a>
                        <a href="{{ route('login') }}" class="w-full rounded-md bg-white px-5 py-3 text-center text-base font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:w-auto dark:bg-slate-800 dark:text-white dark:ring-slate-600 dark:hover:bg-slate-700">
                            Sign In
                        </a>
                    @endauth
                    <a href="#features" class="text-base font-semibold leading-6 text-slate-900 dark:text-white">
                        Learn more <span aria-hidden="true">→</span>
                    </a>
                </div>
                <p class="mt-6 text-sm text-slate-500 dark:text-slate-400">
                    ✓ Free to create  •  ✓ No credit card required  •  ✓ Privacy controls
                </p>
            </div>
            <div class="w-full lg:w-1/2">
                <div class="aspect-video overflow-hidden rounded-2xl shadow-2xl">
                    <img 
                        src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?w=800&h=600&fit=crop&q=80" 
                        alt="Happy dog in a field" 
                        class="h-full w-full object-cover"
                    >
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="bg-slate-50 py-24 sm:py-32 dark:bg-slate-800/50">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-base font-semibold leading-7 text-indigo-600 dark:text-indigo-400">Everything you need</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                    Create a lasting tribute in minutes
                </p>
                <p class="mt-6 text-lg leading-8 text-slate-600 dark:text-slate-400">
                    Our intuitive platform makes it easy to honor your companion with a beautiful, personalized memorial page.
                </p>
            </div>
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                    <div class="flex flex-col">
                        <div class="mb-6 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                        <dt class="text-base font-semibold leading-7 text-slate-900 dark:text-white">
                            Tell Their Story
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-slate-600 dark:text-slate-400">
                            <p class="flex-auto">Write a heartfelt biography, share favorite memories, and upload photos that capture their personality and spirit.</p>
                        </dd>
                    </div>
                    <div class="flex flex-col">
                        <div class="mb-6 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                        <dt class="text-base font-semibold leading-7 text-slate-900 dark:text-white">
                            Invite Tributes
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-slate-600 dark:text-slate-400">
                            <p class="flex-auto">Let friends and family leave messages, share their own memories, and celebrate the joy your companion brought to everyone.</p>
                        </dd>
                    </div>
                    <div class="flex flex-col">
                        <div class="mb-6 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <dt class="text-base font-semibold leading-7 text-slate-900 dark:text-white">
                            Privacy & Control
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-slate-600 dark:text-slate-400">
                            <p class="flex-auto">Choose who can view and contribute. Make it public, private, or invite-only. Moderate tributes before they appear.</p>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section class="py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-base font-semibold leading-7 text-indigo-600 dark:text-indigo-400">Simple & intuitive</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                    How it works
                </p>
            </div>
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                <ol class="grid grid-cols-1 gap-12 lg:grid-cols-3">
                    <li class="relative pl-9">
                        <div class="absolute left-0 top-0 flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-sm font-bold text-white">1</div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Create an account</h3>
                        <p class="mt-2 text-base text-slate-600 dark:text-slate-400">Sign up for free in seconds. No credit card required.</p>
                    </li>
                    <li class="relative pl-9">
                        <div class="absolute left-0 top-0 flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-sm font-bold text-white">2</div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Build your memorial</h3>
                        <p class="mt-2 text-base text-slate-600 dark:text-slate-400">Add photos, write their story, and customize the design with our easy wizard.</p>
                    </li>
                    <li class="relative pl-9">
                        <div class="absolute left-0 top-0 flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-sm font-bold text-white">3</div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Share & celebrate</h3>
                        <p class="mt-2 text-base text-slate-600 dark:text-slate-400">Invite loved ones to view and contribute their own memories and tributes.</p>
                    </li>
                </ol>
            </div>
            <div class="mt-16 text-center">
                @auth
                    <a href="{{ route('memorials.create') }}" class="inline-flex rounded-md bg-indigo-600 px-5 py-3 text-base font-semibold text-white shadow-sm hover:bg-indigo-500">
                        Create Your Memorial Now
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-flex rounded-md bg-indigo-600 px-5 py-3 text-base font-semibold text-white shadow-sm hover:bg-indigo-500">
                        Get Started Free
                    </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="bg-slate-50 py-24 sm:py-32 dark:bg-slate-800/50">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-xl text-center">
                <h2 class="text-lg font-semibold leading-8 tracking-tight text-indigo-600 dark:text-indigo-400">Testimonials</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                    Honoring beloved companions
                </p>
            </div>
            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 grid-rows-1 gap-8 text-sm leading-6 text-slate-900 sm:mt-20 sm:grid-cols-2 xl:mx-0 xl:max-w-none xl:grid-flow-col xl:grid-cols-3">
                <figure class="col-span-1 rounded-2xl bg-white p-6 shadow-lg ring-1 ring-slate-900/5 dark:bg-slate-800 dark:ring-slate-700">
                    <blockquote class="text-slate-900 dark:text-slate-300">
                        <p>"Creating a memorial for Max was healing. It's comforting to have a place where all our favorite memories live together. Friends from across the country have left beautiful tributes."</p>
                    </blockquote>
                    <figcaption class="mt-6 flex items-center gap-x-4">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30"></div>
                        <div>
                            <div class="font-semibold dark:text-white">Sarah M.</div>
                            <div class="text-slate-600 dark:text-slate-400">Max's mom</div>
                        </div>
                    </figcaption>
                </figure>

                <figure class="col-span-1 rounded-2xl bg-white p-6 shadow-lg ring-1 ring-slate-900/5 dark:bg-slate-800 dark:ring-slate-700">
                    <blockquote class="text-slate-900 dark:text-slate-300">
                        <p>"We lost Luna suddenly, and this memorial became a space where our family could grieve together and celebrate her life. The tributes from loved ones meant everything."</p>
                    </blockquote>
                    <figcaption class="mt-6 flex items-center gap-x-4">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30"></div>
                        <div>
                            <div class="font-semibold dark:text-white">James T.</div>
                            <div class="text-slate-600 dark:text-slate-400">Luna's dad</div>
                        </div>
                    </figcaption>
                </figure>

                <figure class="col-span-1 rounded-2xl bg-white p-6 shadow-lg ring-1 ring-slate-900/5 dark:bg-slate-800 dark:ring-slate-700">
                    <blockquote class="text-slate-900 dark:text-slate-300">
                        <p>"The perfect way to honor Bella's memory. I love that it's not just photos - we captured her personality, her quirks, and all the joy she brought us for 15 wonderful years."</p>
                    </blockquote>
                    <figcaption class="mt-6 flex items-center gap-x-4">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30"></div>
                        <div>
                            <div class="font-semibold dark:text-white">Emily R.</div>
                            <div class="text-slate-600 dark:text-slate-400">Bella's family</div>
                        </div>
                    </figcaption>
                </figure>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="bg-white py-16 sm:py-24 dark:bg-slate-900">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="relative isolate overflow-hidden bg-gradient-to-br from-indigo-600 to-purple-700 px-6 py-24 shadow-2xl sm:rounded-3xl sm:px-24 xl:py-32">
                <h2 class="mx-auto max-w-2xl text-center text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Start honoring your companion today
                </h2>
                <p class="mx-auto mt-4 max-w-xl text-center text-lg leading-8 text-indigo-100">
                    Create a beautiful memorial in minutes. Free forever, no credit card required.
                </p>

                <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                    @auth
                        <a href="{{ route('memorials.create') }}" class="w-full rounded-md bg-white px-6 py-3 text-center text-base font-semibold text-indigo-600 shadow-sm hover:bg-indigo-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white sm:w-auto">
                            Create Memorial
                        </a>
                        <a href="{{ route('dashboard') }}" class="w-full rounded-md border-2 border-white px-6 py-3 text-center text-base font-semibold text-white hover:bg-white/10 sm:w-auto">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="w-full rounded-md bg-white px-6 py-3 text-center text-base font-semibold text-indigo-600 shadow-sm hover:bg-indigo-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white sm:w-auto">
                            Get Started Free
                        </a>
                        <a href="{{ route('login') }}" class="w-full rounded-md border-2 border-white px-6 py-3 text-center text-base font-semibold text-white hover:bg-white/10 sm:w-auto">
                            Sign In
                        </a>
                    @endauth
                </div>

                <svg viewBox="0 0 1024 1024" class="absolute left-1/2 top-1/2 -z-10 h-[64rem] w-[64rem] -translate-x-1/2" aria-hidden="true">
                    <circle cx="512" cy="512" r="512" fill="url(#gradient-cta)" fill-opacity="0.3" />
                    <defs>
                        <radialGradient id="gradient-cta" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(512 512) rotate(90) scale(512)">
                            <stop stop-color="#fff" />
                            <stop offset="1" stop-color="#fff" stop-opacity="0" />
                        </radialGradient>
                    </defs>
                </svg>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-slate-900 py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                <p class="text-sm text-slate-400">
                    © {{ date('Y') }} FourPaws. All rights reserved.
                </p>
                <div class="flex gap-6">
                    <a href="{{ route('privacy') }}" class="text-sm text-slate-400 hover:text-white">
                        Privacy Policy
                    </a>
                    <a href="{{ route('terms') }}" class="text-sm text-slate-400 hover:text-white">
                        Terms of Service
                    </a>
                </div>
            </div>
        </div>
    </footer>
</div>
