<?php

namespace App\Services;

use Illuminate\Http\{Response, UploadedFile};
use App\Imports\PatientsImport;
use App\Jobs\NotifyUserOfCompletedImportJob;

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
        $import = new PatientsImport;
        $import->queue($file)->chain([
            new NotifyUserOfCompletedImportJob(count($import->failures()), $import->getRowCount()),
        ]);

        return new Response (array('status' => true, 'totalAcceptedRecords' => $import->getRowCount(), 'totalRejectedRecords'=> count($import->failures())), 201);
    }

}
