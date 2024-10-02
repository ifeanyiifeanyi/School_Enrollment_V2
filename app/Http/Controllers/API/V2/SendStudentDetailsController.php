<?php

namespace App\Http\Controllers\API\V2;

use Illuminate\Http\Request;
use App\Models\AcceptanceFee;
use App\Http\Controllers\Controller;

class SendStudentDetailsController extends Controller
{
    private $perPage = 15; // Number of items per page

    public function accessStudents(Request $request)
    {
        $students = AcceptanceFee::with(['user', 'user.student'])
            ->where('status', 'paid')
            ->paginate($this->perPage);

        return response()->json($this->formatPaginatedResponse($students));
    }

    public function searchStudents(Request $request, $search)
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

        $students = $query->paginate($this->perPage);

        return response()->json($this->formatPaginatedResponse($students));
    }

    private function formatPaginatedResponse($paginatedData)
    {
        return [
            'current_page' => $paginatedData->currentPage(),
            'data' => $paginatedData->items()->map(function ($fee) {
                return $this->formatStudentData($fee);
            }),
            'first_page_url' => $paginatedData->url(1),
            'from' => $paginatedData->firstItem(),
            'last_page' => $paginatedData->lastPage(),
            'last_page_url' => $paginatedData->url($paginatedData->lastPage()),
            'next_page_url' => $paginatedData->nextPageUrl(),
            'path' => $paginatedData->path(),
            'per_page' => $paginatedData->perPage(),
            'prev_page_url' => $paginatedData->previousPageUrl(),
            'to' => $paginatedData->lastItem(),
            'total' => $paginatedData->total(),
        ];
    }

    private function formatStudentData($fee)
    {
        return [
            'first_name' => $fee->user->first_name ?? 'N/A',
            'last_name' => $fee->user->last_name ?? 'N/A',
            'other_names' => $fee->user->other_names ?? 'N/A',
            'jamb_reg_no' => $fee->user->student->jamb_reg_no ?? 'N/A',
        ];
    }
}
