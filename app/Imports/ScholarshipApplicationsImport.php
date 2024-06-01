<?php

namespace App\Imports;

use App\Models\ScholarApplication;
use Maatwebsite\Excel\Concerns\ToModel;

class ScholarshipApplicationsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // $application = ScholarApplication::find($row['id']);
        // if ($application) {
        //     $application->update([
        //         'status' => $row['status'],
        //     ]);

        //     // Send email notification about the status change
        //     Mail::to($application->user->email)->send(new ScholarshipStatusChanged($application));
        // }

        return null;
    }
}
