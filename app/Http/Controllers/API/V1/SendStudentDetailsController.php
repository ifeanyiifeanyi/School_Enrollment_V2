<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Models\AcceptanceFee;
use App\Http\Controllers\Controller;

class SendStudentDetailsController extends Controller
{
    public function __construct() {}
    public function accessStudents()
    {
        $students = AcceptanceFee::with(['user', 'user.student'])
            ->where('status', 'paid')
            ->get()
            ->map(function ($fee) {
                return [
                    'jamb_reg_no' => $fee->user->student->jamb_reg_no ?? 'N/A',
                    'first_name' => $fee->user->first_name ?? 'N/A',
                    'last_name' => $fee->user->last_name ?? 'N/A',
                    'other_names' => $fee->user->other_names ?? 'N/A',
                ];
            });

        return response()->json($students);
    }

    public function searchStudents($search)
    {
        $query = AcceptanceFee::with(['user', 'user.student'])
            ->where('status', 'paid');

        $query->where(function ($q) use ($search) {
            $q->whereHas('user', function ($userQuery) use ($search) {
                $userQuery->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('other_names', 'LIKE', "%{$search}%");
            })
                ->orWhereHas('user.student', function ($studentQuery) use ($search) {
                    $studentQuery->where('jamb_reg_no', 'LIKE', "%{$search}%");
                });
        });

        $students = $query->get()->map(function ($fee) {
            return $this->formatStudentData($fee);
        });

        return response()->json($students);
    }

    private function formatStudentData($fee)
    {
        return [
            'jamb_reg_no' => $fee->user->student->jamb_reg_no ?? 'N/A',

            'first_name' => $fee->user->first_name ?? 'N/A',
            'last_name' => $fee->user->last_name ?? 'N/A',
            'other_names' => $fee->user->other_names ?? 'N/A',
        ];
    }
}
