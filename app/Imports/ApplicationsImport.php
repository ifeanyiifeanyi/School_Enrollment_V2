<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\AdmissionStatusUpdated;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Collection;

class ApplicationsImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    private $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            DB::beginTransaction();
            try {
                $student = Student::where('application_unique_number', $row['application_no'])->first();
                if (!$student) {
                    $this->errors[] = "Student with application number " . $row['application_no'] . " not found.";
                    DB::rollBack();
                    continue;
                }

                $application = Application::where('user_id', $student->user_id)
                    ->whereNotNull('payment_id')
                    ->first();
                if (!$application) {
                    $this->errors[] = "Application for student " . $student->full_name . " with valid payment_id not found.";
                    DB::rollBack();
                    continue;
                }

                $student->exam_score = $row['exam_score'];
                $student->admission_status = $row['admission_status'];
                $student->save();

                $application->admission_status = $row['admission_status'];
                $application->save();

                Mail::to($student->user->email)->send(new AdmissionStatusUpdated($student, $application));

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error during import: ' . $e->getMessage());
                $this->errors[] = "Error during import for application_no " . $row['application_no'] . ": " . $e->getMessage();
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
