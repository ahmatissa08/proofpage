<?php

namespace App\Mail;

use App\Models\WaitlistEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WaitlistAdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public WaitlistEntry $entry,
        public int $total
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[ProofWork] New signup: {$this->entry->email}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-notification',
        );
    }
}