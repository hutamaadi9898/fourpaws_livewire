<?php

namespace App\Livewire;

use App\Mail\MemorialPublished;
use App\Models\Memorial;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Create Memorial')]
class CreateMemorial extends Component
{
    use WithFileUploads;

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

        // Step 4: No validation needed for checkboxes
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

        // Create memorial with correct schema
        $memorial = Memorial::create([
            'owner_id' => auth()->id(),
            'pet_name' => $this->companionName,
            'title' => $this->companionName."'s Memorial",
            'headline' => $this->favoriteMemory ? Str::limit($this->favoriteMemory, 150) : null,
            'story' => $this->biography,
            'slug' => Str::slug($this->companionName).'-'.Str::random(6),
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
            'status' => 'published',
            'visibility' => $this->isPublic ? 'public' : 'private',
            'published_at' => now(),
        ]);

        // Handle profile photo upload
        if ($this->profilePhoto) {
            $path = $this->profilePhoto->store('memorials/profiles', 'public');
            $memorial->update(['hero_image_path' => $path]);
        }

        // Handle additional photos
        foreach ($this->additionalPhotos as $index => $photo) {
            if ($photo) {
                $path = $photo->store('memorials/gallery', 'public');
                $memorial->mediaAssets()->create([
                    'collection' => 'gallery',
                    'disk' => 'public',
                    'path' => $path,
                    'type' => 'image',
                    'sort_order' => $index,
                ]);
            }
        }

        // Send memorial published email
        Mail::to(auth()->user()->email)->send(new MemorialPublished($memorial));

        session()->flash('success', 'Memorial created successfully!');

        $this->redirect(route('memorials.show', $memorial->slug), navigate: true);
    }

    public function render()
    {
        return view('livewire.create-memorial', [
            'themeColors' => $this->themeColors,
        ])->layout('components.layouts.app');
    }
}
