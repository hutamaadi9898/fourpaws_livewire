<?php

namespace App\Livewire;

use App\Mail\TributeSubmitted;
use App\Models\Memorial;
use App\Models\Tribute;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;

class ShowMemorial extends Component
{
    public Memorial $memorial;

    // Tribute form
    public string $tributeAuthorName = '';

    public string $tributeAuthorEmail = '';

    public string $tributeMessage = '';

    public bool $tributeSubmitted = false;

    public function mount(Memorial $memorial): void
    {
        // Check if memorial is public or user is owner
        if ($memorial->visibility !== 'public' && (! auth()->check() || auth()->id() !== $memorial->owner_id)) {
            abort(404);
        }

        $this->memorial = $memorial;
    }

    public function rules(): array
    {
        return [
            'tributeAuthorName' => ['required', 'string', 'max:255'],
            'tributeAuthorEmail' => ['required', 'email', 'max:255'],
            'tributeMessage' => ['required', 'string', 'max:2000'],
        ];
    }

    public function submitTribute(): void
    {
        // Check if tributes are allowed
        if (! ($this->memorial->settings['allow_tributes'] ?? true)) {
            session()->flash('error', 'Tributes are not allowed for this memorial.');

            return;
        }

        $this->validate();

        $status = ($this->memorial->settings['moderate_tributes'] ?? true) ? 'pending' : 'approved';

        $tribute = Tribute::create([
            'memorial_id' => $this->memorial->id,
            'submitter_name' => $this->tributeAuthorName,
            'submitter_email' => $this->tributeAuthorEmail,
            'message' => $this->tributeMessage,
            'status' => $status,
            'published_at' => $status === 'approved' ? now() : null,
        ]);

        // Send notification to memorial owner
        Mail::to($this->memorial->owner->email)->send(new TributeSubmitted($tribute));

        $this->reset(['tributeAuthorName', 'tributeAuthorEmail', 'tributeMessage']);
        $this->tributeSubmitted = true;
    }

    #[Title('Memorial')]
    public function render()
    {
        $approvedTributes = $this->memorial->tributes()
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('livewire.show-memorial', [
            'tributes' => $approvedTributes,
        ])->layout('components.layouts.app');
    }
}
