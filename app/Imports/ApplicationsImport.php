<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Application;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ApplicationsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Begin transaction to ensure data integrity
        DB::beginTransaction();

        try {
            // Find the Student by the application_unique_number
            $student = Student::where('application_unique_number', $row['application_no'])->first();

            if ($student) {
                // Find the corresponding Application record through the User model
                $application = Application::where('user_id', $student->user_id)->first();

                if ($application) {
                    // Update the student's exam score and application's admission status
                    $student->exam_score = $row['exam_score'];
                    $student->admission_status = $row['admission_status'];
                    $student->save();

                    $application->admission_status = $row['admission_status'];
                    $application->save();
                }
            }

            // Commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();
            // Optionally, log the error or handle it as needed
            logger()->error('Error during import: ' . $e->getMessage());
            return null;
        }

        // Return the application if needed or null
        return isset($application) ? $application : null;
    }
}
