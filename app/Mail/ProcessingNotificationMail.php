<?php

namespace App\Mail;

use App\Models\Reporter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProcessingNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $report;

    public function __construct(Reporter $report)
    {
        $this->report = $report;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Informasi: Laporan Telah Dilengkapi',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.email-bk.proses_laporan',
            with: ['report' => $this->report],
        );
    }
}