<?php

namespace App\Jobs;

use App\Mail\NotifyUserOfCompletedImportMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyUserOfCompletedImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rejectedRecords, $accedptedRecords;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $rejectedRecords, int $accedptedRecords)
    {
        $this->rejectedRecords = $rejectedRecords;
        $this->accedptedRecords = $accedptedRecords;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to(User::where('role', 'Admin')->find(1))->send(new NotifyUserOfCompletedImportMail($this->rejectedRecords, $this->accedptedRecords));
    }
}
