<?php

namespace App\Livewire;

use App\Models\Memorial;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Edit Memorial')]
class EditMemorial extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public Memorial $memorial;

    // Wizard state
    public int $currentStep = 1;

    public int $totalSteps = 4;

    // Step 1: Companion Information
    public string $companionName = '';

    public string $species = '';

    public ?string $breed = null;

    public ?string $dateOfBirth = null;

    public ?string $dateOfPassing = null;

    // Step 2: Story & Biography
    public ?string $biography = null;

    public ?string $favoriteMemory = null;

    public array $personality = [];

    // Step 3: Design & Theme
    public string $themeColor = 'indigo';

    public string $layoutStyle = 'classic';

    public $profilePhoto = null;

    public array $additionalPhotos = [];

    // Step 4: Privacy & Settings
    public bool $isPublic = true;

    public bool $allowTributes = true;

    public bool $moderateTributes = true;

    protected array $themeColors = [
        'indigo' => 'Indigo',
        'blue' => 'Blue',
        'purple' => 'Purple',
        'pink' => 'Pink',
        'rose' => 'Rose',
        'orange' => 'Orange',
        'green' => 'Green',
    ];

    public function mount(Memorial $memorial): void
    {
        // Authorization check
        $this->authorize('update', $memorial);

        $this->memorial = $memorial;

        // Load existing data
        $this->companionName = $memorial->pet_name;
        $this->species = $memorial->species ?? '';
        $this->breed = $memorial->breed;
        $this->dateOfBirth = $memorial->date_of_birth?->format('Y-m-d');
        $this->dateOfPassing = $memorial->date_of_passing?->format('Y-m-d');
        $this->biography = $memorial->biography;
        $this->favoriteMemory = $memorial->favorite_memory;
        $this->personality = $memorial->personality ?? [];
        $this->themeColor = $memorial->theme['color'] ?? 'indigo';
        $this->layoutStyle = $memorial->theme['layout'] ?? 'classic';
        $this->isPublic = $memorial->visibility === 'public';
        $this->allowTributes = $memorial->settings['allow_tributes'] ?? true;
        $this->moderateTributes = $memorial->settings['moderate_tributes'] ?? true;
    }

    protected function rules(): array
    {
        if ($this->currentStep === 1) {
            return [
                'companionName' => ['required', 'string', 'max:255'],
                'species' => ['required', 'string', 'max:100'],
                'breed' => ['nullable', 'string', 'max:100'],
                'dateOfBirth' => ['nullable', 'date', 'before:today'],
                'dateOfPassing' => ['nullable', 'date', 'before_or_equal:today', 'after_or_equal:dateOfBirth'],
            ];
        }

        if ($this->currentStep === 2) {
            return [
                'biography' => ['nullable', 'string', 'max:5000'],
                'favoriteMemory' => ['nullable', 'string', 'max:2000'],
                'personality' => ['nullable', 'array'],
            ];
        }

        if ($this->currentStep === 3) {
            return [
                'themeColor' => ['required', 'string', 'in:'.implode(',', array_keys($this->themeColors))],
                'layoutStyle' => ['required', 'string', 'in:classic,modern,elegant'],
                'profilePhoto' => ['nullable', 'image', 'max:10240'],
                'additionalPhotos.*' => ['nullable', 'image', 'max:10240'],
            ];
        }

        return [
            'isPublic' => ['boolean'],
            'allowTributes' => ['boolean'],
            'moderateTributes' => ['boolean'],
        ];
    }

    public function nextStep(): void
    {
        $this->validate();

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function submit(): void
    {
        $this->validate();

        // Update memorial
        $this->memorial->update([
            'pet_name' => $this->companionName,
            'title' => $this->companionName."'s Memorial",
            'headline' => $this->favoriteMemory ? Str::limit($this->favoriteMemory, 150) : null,
            'story' => $this->biography,
            'species' => $this->species,
            'breed' => $this->breed,
            'date_of_birth' => $this->dateOfBirth,
            'date_of_passing' => $this->dateOfPassing,
            'biography' => $this->biography,
            'favorite_memory' => $this->favoriteMemory,
            'personality' => $this->personality,
            'theme' => [
                'color' => $this->themeColor,
                'layout' => $this->layoutStyle,
            ],
            'settings' => [
                'allow_tributes' => $this->allowTributes,
                'moderate_tributes' => $this->moderateTributes,
            ],
            'visibility' => $this->isPublic ? 'public' : 'private',
        ]);

        // Handle profile photo upload
        if ($this->profilePhoto) {
            $path = $this->profilePhoto->store('memorials/profiles', 'public');
            $this->memorial->update(['hero_image_path' => $path]);
        }

        // Handle additional photos
        foreach ($this->additionalPhotos as $index => $photo) {
            if ($photo) {
                $path = $photo->store('memorials/gallery', 'public');
                $this->memorial->mediaAssets()->create([
                    'collection' => 'gallery',
                    'disk' => 'public',
                    'path' => $path,
                    'type' => 'image',
                    'sort_order' => $this->memorial->mediaAssets()->count() + $index,
                ]);
            }
        }

        session()->flash('success', 'Memorial updated successfully!');

        $this->redirect(route('memorials.show', $this->memorial->slug), navigate: true);
    }

    public function render()
    {
        return view('livewire.edit-memorial', [
            'themeColors' => $this->themeColors,
        ])->layout('components.layouts.app');
    }
}
