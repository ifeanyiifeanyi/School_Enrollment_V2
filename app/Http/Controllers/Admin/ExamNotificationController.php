<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\ExamNotification;
use App\Mail\ExamNotificationMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ExamNotificationController extends Controller
{
    public function index()
    {
        $departments = Department::query()->get();
        // dd($departments);
        return view('admin.examNotification.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'exam_date' => 'required|date',
            'venue' => 'required|string|max:255',
            'requirements' => 'required|string',
        ], [
            'department_id.required' => 'Please select a department',
            'exam_date.required' => 'Please select an exam date',
            'venue.required' => 'Please enter a venue',
            'requirements.required' => 'Please enter exam requirements',
        ]);

        // Check if an exam notification for the selected department already exists
        $existingNotification = ExamNotification::where('department_id', $validatedData['department_id'])->first();

        if ($existingNotification) {
            $notification = [
                'message' => 'An exam notification for this department already exists.',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }


        $examNotification = ExamNotification::create($validatedData);

        // Get students who applied to the selected department
        $applications = Application::where('department_id', $examNotification->department_id)
            ->whereNotNull('payment_id')
            ->get();
        // dd($applications->department);

        foreach ($applications as $application) {
            // Send email notification to each student
            $student = $application->user;
            Mail::to($student->email)->send(new ExamNotificationMail($examNotification, $application));
        }
        $notification = [
            'message' => 'Exam notifications sent successfully!',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    }
}
