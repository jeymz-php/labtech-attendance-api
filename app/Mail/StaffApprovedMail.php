<?php

namespace App\Mail;

use App\Models\Staff;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Staff $staff;
    public string $generatedPassword;

    public function __construct(Staff $staff, string $generatedPassword)
    {
        $this->staff = $staff;
        $this->generatedPassword = $generatedPassword;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your LabTech Attendance account is approved',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.staff-approved',
        );
    }
}