<div class="min-h-screen bg-slate-50 py-12 dark:bg-slate-900">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Create a Memorial</h1>
            <p class="mt-2 text-slate-600 dark:text-slate-400">Honor your beloved companion with a beautiful tribute</p>
        </div>

        
        <nav aria-label="Progress" class="mb-8">
            <ol class="flex items-center justify-between">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = range(1, $totalSteps); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="relative flex flex-1 items-center <?php echo e($step < $totalSteps ? 'pr-8 sm:pr-20' : ''); ?>">
                        <!--[if BLOCK]><![endif]--><?php if($step < $totalSteps): ?>
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="h-0.5 w-full <?php echo e($currentStep > $step ? 'bg-indigo-600' : 'bg-slate-200 dark:bg-slate-700'); ?>"></div>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div class="relative flex h-8 w-8 items-center justify-center rounded-full <?php echo e($currentStep > $step ? 'bg-indigo-600' : ($currentStep === $step ? 'border-2 border-indigo-600 bg-white dark:bg-slate-800' : 'border-2 border-slate-300 bg-white dark:border-slate-600 dark:bg-slate-800')); ?>">
                            <span class="text-sm font-semibold <?php echo e($currentStep >= $step ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-500 dark:text-slate-400'); ?>"><?php echo e($step); ?></span>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </ol>
        </nav>

        
        <div class="rounded-lg bg-white p-8 shadow dark:bg-slate-800">
            <form wire:submit="submit">
                
                <!--[if BLOCK]><![endif]--><?php if($currentStep === 1): ?>
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Tell us about your companion</h2>

                        <div>
                            <label for="companionName" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                                Companion's Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                wire:model="companionName" 
                                type="text" 
                                id="companionName" 
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white sm:text-sm"
                                required
                            >
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['companionName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="species" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Species <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    wire:model="species" 
                                    id="species" 
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white sm:text-sm"
                                    required
                                >
                                    <option value="">Select species</option>
                                    <option value="Dog">Dog</option>
                                    <option value="Cat">Cat</option>
                                    <option value="Bird">Bird</option>
                                    <option value="Rabbit">Rabbit</option>
                                    <option value="Horse">Horse</option>
                                    <option value="Other">Other</option>
                                </select>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['species'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <div>
                                <label for="breed" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Breed</label>
                                <input 
                                    wire:model="breed" 
                                    type="text" 
                                    id="breed" 
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white sm:text-sm"
                                >
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['breed'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="dateOfBirth" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Date of Birth</label>
                                <input 
                                    wire:model="dateOfBirth" 
                                    type="date" 
                                    id="dateOfBirth" 
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white sm:text-sm"
                                >
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['dateOfBirth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <div>
                                <label for="dateOfPassing" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Date of Passing</label>
                                <input 
                                    wire:model="dateOfPassing" 
                                    type="date" 
                                    id="dateOfPassing" 
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white sm:text-sm"
                                >
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['dateOfPassing'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                
                <!--[if BLOCK]><![endif]--><?php if($currentStep === 2): ?>
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Share their story</h2>

                        <div>
                            <label for="biography" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Biography</label>
                            <textarea 
                                wire:model="biography" 
                                id="biography" 
                                rows="6" 
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white sm:text-sm"
                                placeholder="Tell us about their life, personality, and what made them special..."
                            ></textarea>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['biography'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <div>
                            <label for="favoriteMemory" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Favorite Memory</label>
                            <textarea 
                                wire:model="favoriteMemory" 
                                id="favoriteMemory" 
                                rows="4" 
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white sm:text-sm"
                                placeholder="Share a cherished memory or moment you'll never forget..."
                            ></textarea>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['favoriteMemory'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                
                <!--[if BLOCK]><![endif]--><?php if($currentStep === 3): ?>
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Customize the design</h2>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Theme Color</label>
                            <div class="mt-2 grid grid-cols-4 gap-3 sm:grid-cols-7">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $themeColors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button 
                                        type="button"
                                        wire:click="$set('themeColor', '<?php echo e($key); ?>')"
                                        class="relative flex h-12 w-12 items-center justify-center rounded-full bg-<?php echo e($key); ?>-500 ring-2 <?php echo e($themeColor === $key ? 'ring-slate-900 dark:ring-white' : 'ring-transparent'); ?>"
                                    >
                                        <!--[if BLOCK]><![endif]--><?php if($themeColor === $key): ?>
                                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Layout Style</label>
                            <div class="mt-2 grid grid-cols-1 gap-4 sm:grid-cols-3">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = ['classic' => 'Classic', 'modern' => 'Modern', 'elegant' => 'Elegant']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button 
                                        type="button"
                                        wire:click="$set('layoutStyle', '<?php echo e($key); ?>')"
                                        class="relative rounded-lg border-2 p-4 text-left <?php echo e($layoutStyle === $key ? 'border-indigo-600' : 'border-slate-300 dark:border-slate-600'); ?>"
                                    >
                                        <span class="font-medium text-slate-900 dark:text-white"><?php echo e($label); ?></span>
                                    </button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                
                <!--[if BLOCK]><![endif]--><?php if($currentStep === 4): ?>
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Privacy settings</h2>

                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex h-5 items-center">
                                    <input 
                                        wire:model="isPublic" 
                                        id="isPublic" 
                                        type="checkbox" 
                                        class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                                    >
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="isPublic" class="font-medium text-slate-700 dark:text-slate-300">Make memorial public</label>
                                    <p class="text-slate-500 dark:text-slate-400">Allow anyone with the link to view this memorial</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex h-5 items-center">
                                    <input 
                                        wire:model="allowTributes" 
                                        id="allowTributes" 
                                        type="checkbox" 
                                        class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                                    >
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="allowTributes" class="font-medium text-slate-700 dark:text-slate-300">Allow tributes</label>
                                    <p class="text-slate-500 dark:text-slate-400">Let others share memories and photos</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex h-5 items-center">
                                    <input 
                                        wire:model="moderateTributes" 
                                        id="moderateTributes" 
                                        type="checkbox" 
                                        class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                                    >
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="moderateTributes" class="font-medium text-slate-700 dark:text-slate-300">Moderate tributes</label>
                                    <p class="text-slate-500 dark:text-slate-400">Review tributes before they appear publicly</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-md bg-indigo-50 p-4 dark:bg-indigo-900/20">
                            <div class="flex">
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-indigo-800 dark:text-indigo-300">Ready to create</h3>
                                    <div class="mt-2 text-sm text-indigo-700 dark:text-indigo-400">
                                        <p>Your memorial for <?php echo e($companionName); ?> is ready to be published.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                
                <div class="mt-8 flex justify-between border-t border-slate-200 pt-5 dark:border-slate-700">
                    <button 
                        type="button" 
                        wire:click="previousStep" 
                        <?php if($currentStep === 1): ?> disabled <?php endif; ?>
                        class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-50 dark:bg-slate-700 dark:text-white dark:ring-slate-600"
                    >
                        Previous
                    </button>

                    <div class="flex gap-3">
                        <!--[if BLOCK]><![endif]--><?php if($currentStep < $totalSteps): ?>
                            <button 
                                type="button" 
                                wire:click="nextStep" 
                                class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
                            >
                                Next
                            </button>
                        <?php else: ?>
                            <button 
                                type="submit" 
                                class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
                            >
                                Create Memorial
                            </button>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\hutam\Herd\fourpaws\resources\views/livewire/create-memorial.blade.php ENDPATH**/ ?>