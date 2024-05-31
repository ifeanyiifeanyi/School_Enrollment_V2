<?php

namespace App\Http\Controllers\Student;

use App\Models\Application;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use App\Models\ScholarAnswer;
use App\Models\ScholarApplication;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScholarshipApplicationReceived;

class ScholarshipApplicationController extends Controller
{
    public function index()
    {
        $scholarships = Scholarship::with('questions')->latest()->get();
        return view('student.scholarship.index', compact('scholarships'));
    }

    // get the question for each individual scholarship application
    public function getQuestions($id)
    {
        $scholarship = Scholarship::find($id);
        if ($scholarship) {
            $questions = $scholarship->questions;
            return response()->json(['questions' => $questions]);
        } else {
            return response()->json(['message' => 'Scholarship not found'], 404);
        }
    }

    // used for the modal that shows student the scholarship details
    public function showDetail($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        return response()->json($scholarship);
    }

    // apply for scholarship
    public function apply(Request $request)
    {
        $request->validate([
            'scholarship_id' => 'required|exists:scholarships,id',
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        // Check if the student has applied for admission
        // NOTE: later return to make it that only admitted students can apply
        $admissionApplication = Application::where('user_id', auth()->user()->id)->first();

        if (!$admissionApplication) {
            $notification = [
                'message' => 'You need to apply for admission before applying for a scholarship.',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        // Check if the student has already applied for the selected scholarship
        $existingApplication = ScholarApplication::where('user_id', auth()->user()->id)
            ->where('scholarship_id', $request->scholarship_id)
            ->first();

        if ($existingApplication) {
            $notification = [
                'message' => 'You have already applied for this scholarship.',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        // Store application
        $application = ScholarApplication::create([
            'user_id' => auth()->user()->id,
            'scholarship_id' => $request->scholarship_id,
            'status' => 'pending',
        ]);

        // Store the answered questions
        foreach ($request->answers as $question_id => $answer_text) {
            ScholarAnswer::create([
                'application_id' => $application->id,
                'scholarship_id' => $request->scholarship_id,
                'scholar_question_id' => $question_id,
                'answer_text' => $answer_text,
            ]);
        }

        // Send email notification
        Mail::to(auth()->user()->email)->send(new ScholarshipApplicationReceived($application));


        $notification = [
            'message' => 'Application Submitted Successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('student.scholarships.status')->with($notification);
    }


    //
    public function scholarshipStatus()
    {
        $application = ScholarApplication::where('user_id', auth()->id())->firstOrFail();
        return view('student.scholarship.status', compact('application'));
    }
}
