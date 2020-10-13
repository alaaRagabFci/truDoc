<?php

namespace App\Imports;

use App\Models\Patient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\{Importable, SkipsFailures, SkipsOnFailure, ToModel, WithBatchInserts, WithChunkReading, WithStartRow, WithValidation};

class PatientsImport implements
      ToModel,
      WithStartRow,
      WithValidation,
      SkipsOnFailure,
      WithBatchInserts,
      WithChunkReading,
      ShouldQueue
{
    use Importable, SkipsFailures;

    private $rows = 0;

    public function rules(): array
    {
        return [
            '*.0' => 'required',
            '*.1' => 'required',
            '*.2' => 'required',
            '*.3' => 'required',
        ];
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row): Patient
    {
        ++$this->rows;

        return new Patient([
            'first_name' => $row[0],
            'second_name' => $row[1],
            'family_name' => $row[2],
            'national_id' => $row[3],
        ]);
    }

    /**
     * @return int
    */
    public function getRowCount(): int
    {
        return $this->rows;
    }

    /**
     * @return int
    */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @return int
    */
    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * @return int
    */
    public function chunkSize(): int
    {
        return 1000;
    }

}
