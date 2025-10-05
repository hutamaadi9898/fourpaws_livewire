<?php

namespace App\Livewire;

use App\Mail\TributeApproved;
use App\Models\Tribute;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Tribute Moderation')]
class TributeModeration extends Component
{
    use WithPagination;

    public string $statusFilter = 'pending';

    public function approveTribute(string $tributeId): void
    {
        $tribute = Tribute::findOrFail($tributeId);

        // Check if user owns the memorial
        if ($tribute->memorial->owner_id !== auth()->id()) {
            abort(403);
        }

        $tribute->update([
            'status' => 'approved',
            'approved_at' => now(),
            'moderated_by' => auth()->user()->name,
        ]);

        // Send notification email to submitter
        Mail::to($tribute->submitter_email)->send(new TributeApproved($tribute));

        session()->flash('success', 'Tribute approved successfully!');
    }

    public function rejectTribute(string $tributeId): void
    {
        $tribute = Tribute::findOrFail($tributeId);

        // Check if user owns the memorial
        if ($tribute->memorial->owner_id !== auth()->id()) {
            abort(403);
        }

        $tribute->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'moderated_by' => auth()->user()->name,
        ]);

        session()->flash('success', 'Tribute rejected.');
    }

    public function render()
    {
        $tributes = Tribute::query()
            ->whereHas('memorial', fn ($query) => $query->where('owner_id', auth()->id()))
            ->when($this->statusFilter !== 'all', fn ($query) => $query->where('status', $this->statusFilter))
            ->with(['memorial'])
            ->latest()
            ->paginate(10);

        return view('livewire.tribute-moderation', [
            'tributes' => $tributes,
        ])->layout('components.layouts.app');
    }
}
