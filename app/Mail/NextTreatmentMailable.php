<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Date;
use Carbon\Carbon;

class NextTreatmentMailable extends Mailable
{
    use Queueable, SerializesModels;

    private Carbon $nextTreatmentDate;

    /**
     * Create a new message instance.
     */
    public function __construct(Carbon $nextTreatmentDate)
    {
        $this->nextTreatmentDate = $nextTreatmentDate;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Próximo Tratamiento',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'treatment.nextTreatment',
            with: [
                'nextTreatmentDate' => $this->nextTreatmentDate,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
