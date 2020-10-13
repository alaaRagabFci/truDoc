<?php

namespace App\Http\Controllers;

use App\Services\PatientService;
use Illuminate\Http\Response;

class PatientController extends Controller
{
    protected $patientService;

    /**
     * Create a new controller instance.
     * @param PatientService
     * @return void
     */
    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function patientsImport(): Response
    {
        return $this->patientService->patientsImport(request()->file('file'));
    }
}
