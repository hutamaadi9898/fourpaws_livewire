<?php

namespace App\Mail;

use App\Models\Memorial;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MemorialPublished extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(public Memorial $memorial) {}

    public function envelope(): Envelope
    {
        $petName = $this->memorial->pet_name ?: 'your companion';

        return new Envelope(
            subject: 'Your memorial for '.$petName.' is ready to share',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.memorial-published',
            with: [
                'memorial' => $this->memorial,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
