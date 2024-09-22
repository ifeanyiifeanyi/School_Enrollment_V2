<?php

namespace App\Imports;

use App\Models\ScholarApplication;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScholarshipStatusChanged;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScholarshipApplicationsImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    private $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            DB::beginTransaction();
            try {
                $application = ScholarApplication::find($row['id']);
                if (!$application) {
                    $this->errors[] = "Scholarship application with ID " . $row['id'] . " not found.";
                    DB::rollBack();
                    continue;
                }

                $oldStatus = $application->status;
                $application->status = $row['status'];
                $application->save();

                if ($oldStatus !== $row['status']) {
                    Mail::to($application->user->email)->send(new ScholarshipStatusChanged($application));
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error during scholarship import: ' . $e->getMessage());
                $this->errors[] = "Error processing scholarship application ID " . $row['id'] . ": " . $e->getMessage();
            }
        }
    }

    public function chunkSize(): int
    {
        return 100;  // Process 100 rows at a time
    }

    public function batchSize(): int
    {
        return 100;  // Insert 100 records at a time
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
