<?php

namespace App\Exports;

use App\Models\ScholarApplication;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ScholarshipApplicationsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ScholarApplication::with('user', 'scholarship')->get()->map(function ($application) {
            return [
                'id' => $application->id,
                'student_name' => $application->user->full_name,
                'student_email' => $application->user->email,
                'scholarship_name' => $application->scholarship->name,
                'status' => $application->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Student Name',
            'Student Email',
            'Scholarship Name',
            'Status',
        ];
    }
}
