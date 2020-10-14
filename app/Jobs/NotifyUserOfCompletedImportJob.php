<?php

namespace App\Jobs;

use App\Mail\NotifyUserOfCompletedImportMail;
use App\Models\Patient;
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

    protected $rowCountOld, $fileRecordsCount;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $rowCountOld, int $fileRecordsCount)
    {
        $this->rowCountOld = $rowCountOld;
        $this->fileRecordsCount = $fileRecordsCount;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $rowCountNew = Patient::count();
        $acceptedRecords = $rowCountNew - $this->rowCountOld;
        $rejectedRecords = $this->fileRecordsCount - $acceptedRecords;

        Mail::to(User::where('role', 'Admin')->find(1))->send(new NotifyUserOfCompletedImportMail($rejectedRecords, $acceptedRecords));
    }
}
