<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $inquiry;
    public string $body;
    public ?User $admin;

    public function __construct(array $inquiry, string $subject, string $body, ?User $admin = null)
    {
        $this->inquiry = $inquiry;
        $this->subject($subject);
        $this->body = $body;
        $this->admin = $admin;
    }

    public function build()
    {
        return $this->view('emails.inquiry_reply');
    }
}
