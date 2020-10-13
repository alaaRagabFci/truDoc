<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyUserOfCompletedImportMail extends Mailable
{
    use SerializesModels;

    protected $rejectedRecords, $accedptedRecords;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(int $rejectedRecords, int $accedptedRecords)
    {
        $this->rejectedRecords = $rejectedRecords;
        $this->accedptedRecords = $accedptedRecords;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.patients')
        ->with([
            'rejectedRecords' => $this->rejectedRecords,
            'accedptedRecords' => $this->accedptedRecords,
        ]);
    }
}
