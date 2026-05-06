<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BulkCourseMail extends Mailable {
    use Queueable, SerializesModels;

    public string $studentName;
    public string $courseTitle;

    public function __construct(string $studentName, string $courseTitle) {
        $this->studentName = $studentName;
        $this->courseTitle = $courseTitle;
    }

    public function envelope(): Envelope {
        return new Envelope(
            subject: 'F1 Academy – Message from your Instructor',
        );
    }

    public function content(): Content {
        return new Content(
            view: 'mails.bulk_course',
        );
    }
}