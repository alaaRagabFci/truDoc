<?php

namespace Tests\Unit;

use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class PatientTest extends TestCase
{
    public function testThatItImportsTheUploadedFile() {
        $file = new UploadedFile(
            base_path('tests\files\patients.xlsx'),
            'patients.xlsx',
            null,
            null,
            true
        );

        $result = $this->post('/api/patients-import', [
            'file' => $file
        ]);

        $result->assertStatus(200);
        $result->assertJson([
            'status' =>  true
        ]);

    }
}
