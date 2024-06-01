<?php

namespace App\Imports;

use App\Models\ScholarApplication;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScholarshipStatusChanged;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ScholarshipApplicationsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        // Ensure the keys match your Excel headers
        $application = ScholarApplication::find($row['id']);
        if ($application) {
            $application->update([
                'status' => $row['status'],
            ]);

            // Send email notification about the status change
            Mail::to($application->user->email)->send(new ScholarshipStatusChanged($application));
        }

        return null;
    }
}
