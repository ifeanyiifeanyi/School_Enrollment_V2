<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;




// class ApplicationsExport implements FromCollection
class ApplicationsExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    private $departmentId;

    public function __construct($departmentId = null)
    {
        $this->departmentId = $departmentId;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Application::query()->with(['user.student', 'department']);

        if ($this->departmentId) {
            $query->where('department_id', $this->departmentId);
        }

        return $query->get()->map(function ($application) {
            return [
                'Student Name' => $application->user->full_name,
                'Application No' => $application->user->student->application_unique_number,
                'Department' => $application->department->name,
                'Exam Score' => $application->user->student->exam_score,
                'Admission Status' => $application->admission_status
            ];
        });
    }


    public function headings(): array
    {
        return ['Student Name', 'Application No', 'Department', 'Exam Score', 'Admission Status'];
    }
}
