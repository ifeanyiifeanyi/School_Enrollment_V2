<?php

namespace App\Exports;

use App\Models\Application;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportAllStudents implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // dd(User::with(['student']));

        $users = User::with(['student'])->where('role', 'student')->get();

        return $users->map(function ($user) {
            return [
                'Student Name' => $user->full_name,
                'Application No' => $user->student->application_unique_number ?? null,
                'Phone' => $user->student->phone ?? null,
            ];
        });
    }
    public function headings(): array
    {
        return ['Student Name', 'Application No', 'Phone'];
    }
}
