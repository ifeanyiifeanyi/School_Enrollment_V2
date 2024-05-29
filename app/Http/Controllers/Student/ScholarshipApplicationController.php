<?php

namespace App\Http\Controllers\Student;

use App\Models\Scholarship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScholarshipApplicationController extends Controller
{
    public function index(){
        $scholarships = Scholarship::with('questions')->get();
        return view('student.scholarship.index', compact('scholarships'));
    }

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

    public function showDetail($id)
{
    $scholarship = Scholarship::findOrFail($id);
    return response()->json($scholarship);
}
}
