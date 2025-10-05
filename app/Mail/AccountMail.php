<?php

declare(strict_types=1);

namespace App\Mail;

use Hypervel\Bus\Queueable;
use Hypervel\Mail\Mailable;
use Hypervel\Mail\Mailables\Content;
use Hypervel\Mail\Mailables\Envelope;
use Hypervel\Queue\Contracts\ShouldQueue;
use Hypervel\Queue\SerializesModels;

class AccountMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $param;

    /**
     * Create a new message instance.
     */
    public function __construct($param)
    {
        $this->param = $param;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->param['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: $this->param['view'],
            with: $this->param['data'] ?? [],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Hypervel\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}