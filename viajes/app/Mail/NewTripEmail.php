<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewTripEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    private $id;
    private $name;
    private $subjectCustom;

    public function __construct($name,$id,$subjectCustom)
    {
        $this->id = $id;
        $this->name = $name;
        $this->subjectCustom = $subjectCustom;
        
    }

    public function build()
    {
        return $this->markdown('emails.mail-new-account')
        ->with([
            'name' => $this->name,
            'id' => $this->id,
            'content' => 'Ha recibido este E-mail de parte de Drivo'
        ]);
        
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectCustom,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
