<?php

namespace App\Http\Controllers\Student;

use App\Models\Scholarship;
use Illuminate\Http\Request;
use App\Models\ScholarAnswer;
use App\Models\ScholarApplication;
use App\Http\Controllers\Controller;

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

        // store application
        $application = ScholarApplication::create([
            'user_id' => auth()->user()->id,
            'scholarship_id' => $request->scholarship_id,
            'status' => 'pending',
        ]);

        // store the answered questions
        foreach ($request->answers as $question_id => $answer_text) {
            ScholarAnswer::create([
                'application_id' => $application->id,
                'scholarship_id' => $request->scholarship_id,
                'scholar_question_id' => $question_id,
                'answer_text' => $answer_text,
            ]);
        }

        $notification = [
            'message' => 'Application Submitted Successfully!',
            'alert-type' => 'success'
        ];
        return redirect()->route('scholarships.status.detail')->with($notification);
    }

    //
    public function scholarshipStatus()
    {
        // dd('hello');
        $application = ScholarApplication::where('user_id', auth()->id())->firstOrFail();
        return view('student.scholarship.status', compact('application'));
        // return view('student.scholarship.index', compact('scholarships'));

    }

    public function NewView(){
        return view('student.scholarship.new');
    }
}
