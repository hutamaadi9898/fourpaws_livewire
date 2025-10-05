<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            <?php echo e(__('My Memorials')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <?php
                $memorials = auth()->user()->memorials()->latest()->get();
            ?>

            <?php if($memorials->isEmpty()): ?>
                
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
                            <a href="<?php echo e(route('memorials.create')); ?>" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Create Memorial
                            </a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                
                <div class="mb-6 flex items-center justify-between">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <?php echo e($memorials->count()); ?> <?php echo e(Str::plural('memorial', $memorials->count())); ?>

                    </p>
                    <a href="<?php echo e(route('memorials.create')); ?>" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        New Memorial
                    </a>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php $__currentLoopData = $memorials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $memorial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="group relative overflow-hidden rounded-lg bg-white shadow transition hover:shadow-lg dark:bg-gray-800">
                            
                            <div class="h-32 bg-gradient-to-br from-<?php echo e($memorial->theme['color'] ?? 'indigo'); ?>-400 to-<?php echo e($memorial->theme['color'] ?? 'indigo'); ?>-600"></div>
                            
                            
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                    <?php echo e($memorial->companion_name); ?>

                                </h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    <?php echo e($memorial->species); ?>

                                    <?php if($memorial->breed): ?>
                                        • <?php echo e($memorial->breed); ?>

                                    <?php endif; ?>
                                </p>
                                
                                <?php if($memorial->date_of_birth || $memorial->date_of_passing): ?>
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-500">
                                        <?php if($memorial->date_of_birth && $memorial->date_of_passing): ?>
                                            <?php echo e(\Carbon\Carbon::parse($memorial->date_of_birth)->format('M Y')); ?> - 
                                            <?php echo e(\Carbon\Carbon::parse($memorial->date_of_passing)->format('M Y')); ?>

                                        <?php elseif($memorial->date_of_passing): ?>
                                            <?php echo e(\Carbon\Carbon::parse($memorial->date_of_passing)->format('M d, Y')); ?>

                                        <?php endif; ?>
                                    </p>
                                <?php endif; ?>

                                <div class="mt-4 flex items-center justify-between">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium <?php echo e($memorial->is_public ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'); ?>">
                                        <?php echo e($memorial->is_public ? 'Public' : 'Private'); ?>

                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        <?php echo e($memorial->tributes()->where('status', 'approved')->count()); ?> tributes
                                    </span>
                                </div>

                                <div class="mt-4 flex gap-2">
                                    <a href="<?php echo e(route('memorials.show', $memorial->slug)); ?>" class="flex-1 rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                        View
                                    </a>
                                    <button class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\hutam\Herd\fourpaws\resources\views/dashboard.blade.php ENDPATH**/ ?>