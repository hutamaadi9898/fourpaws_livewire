<?php

namespace App\Mail;

use App\Models\Tribute;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TributeSubmitted extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(public Tribute $tribute) {}

    public function envelope(): Envelope
    {
        $memorial = $this->tribute->memorial;
        $petName = $memorial?->pet_name ?: 'your memorial';

        return new Envelope(
            subject: 'New tribute awaiting approval for '.$petName,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.tribute-submitted',
            with: [
                'tribute' => $this->tribute,
                'memorial' => $this->tribute->memorial,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
