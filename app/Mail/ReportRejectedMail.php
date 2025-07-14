<?php

namespace App\Mail;

use App\Models\Reporter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportRejectedMail extends Mailable
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
            subject: 'Informasi: Laporan Anda Ditolak',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.email-siswa.ditolak',
            with: ['report' => $this->report],
        );
    }
}