<?php

namespace App\Services;

use Illuminate\Http\{Response, UploadedFile};
use App\Imports\PatientsImport;
use App\Jobs\NotifyUserOfCompletedImportJob;
use App\Models\Patient;

class PatientService
{
    /**
     * Import patients.
     * @param  UploadedFile $file
     * @return \Illuminate\Http\Response
     * @author alaa <alaaragab34@gmail.com>
     */
    public function patientsImport(UploadedFile $file): Response
    {
        // $rowCount = $import->getRowCount();
        // $failureCount = count($import->failures());
        $rowCountOld = Patient::count();
        $import = new PatientsImport;
        $fileRecordsCount = count((new PatientsImport)->toArray($file)[0]);

        $import->queue($file)->chain([
            new NotifyUserOfCompletedImportJob($rowCountOld, $fileRecordsCount),
        ]);

        return new Response (array('status' => true, 'message' => 'Importing will run at background and email will send with accepted & rejected records.'), 201);
    }

}
