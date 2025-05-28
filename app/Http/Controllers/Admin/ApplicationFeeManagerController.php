<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use App\Models\Department;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApplicationFeeManagerController extends Controller
{
    public function index(Request $request){
        $departments = Department::latest()->get();
        $departmentId = $request->input('department_id');

        $query = Application::with(['user.student', 'department', 'academicSession', 'payment'])
            ->whereNotNull('payment_id')
            ->where('payment_id', '!=', '');

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        // Calculate totals before pagination
        $totalStudents = $query->count();
        $totalAmount = Payment::whereIn('id', $query->pluck('payment_id'))
            ->sum('amount');

        $applications = $query->orderBy('created_at', 'desc')
            ->distinct()
            ->paginate(100);

        return view('admin.application_fees.index', compact('applications', 
        'totalStudents', 'totalAmount', 'departments'));
    }
}
