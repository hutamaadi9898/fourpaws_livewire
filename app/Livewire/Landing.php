<?php

namespace App\Livewire;

use App\Jobs\SyncWaitlistSignup;
use App\Models\WaitlistSignup;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('FourPaws Studio — Pet Memorials That Last Forever')]
class Landing extends Component
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

    public function render()
    {
        return view('livewire.landing')->layout('components.layouts.app');
    }
}
