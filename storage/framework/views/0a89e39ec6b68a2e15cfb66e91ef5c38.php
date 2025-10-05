<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo e($title ?? 'Page Title'); ?></title>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    </head>
    <body class="antialiased bg-white dark:bg-slate-900">
        
        <nav class="border-b border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <a href="<?php echo e(route('landing')); ?>" class="text-xl font-bold text-indigo-600">
                            🐾 FourPaws
                        </a>
                    </div>
                    <div class="flex items-center gap-4">
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('dashboard')); ?>" class="text-sm font-semibold text-slate-700 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">
                                Dashboard
                            </a>
                            <a href="<?php echo e(route('tributes.moderate')); ?>" class="text-sm font-semibold text-slate-700 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">
                                Tributes
                            </a>
                            <a href="<?php echo e(route('memorials.create')); ?>" class="rounded-md bg-indigo-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                Create Memorial
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="text-sm font-semibold text-slate-700 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">
                                Sign In
                            </a>
                            <a href="<?php echo e(route('register')); ?>" class="rounded-md bg-indigo-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                Get Started
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>

        <?php echo e($slot); ?>


        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    </body>
</html>
<?php /**PATH C:\Users\hutam\Herd\fourpaws\resources\views/components/layouts/app.blade.php ENDPATH**/ ?>