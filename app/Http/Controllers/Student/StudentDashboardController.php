<?php

namespace App\Http\Controllers\Student;

use App\Models\Faculty;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentDashboardController extends Controller
{
    public function dashboard(){
        $user = auth()->user();
        $application = $user->applications->first();

       // Generate URL to the student details page
        $barcodeUrl = route('student.details.show', ['nameSlug' => $user->nameSlug]);
        // dd($user->nameSlug);

    

        $faculties = Faculty::has('departments')
        ->with('departments')
        ->simplePaginate(15);

        return view('student.dashboard', compact('faculties', 'application', 'user', 'barcodeUrl'));
    }
    /**
     * Display a listing of the resource.
     */
    public function departmentDetail($id)
    {
        $department = Department::with('exam_managers')->findOrFail($id);
        $examManager = $department->exam_managers;

        // Format the date_time using Carbon
        $formattedDateTime = $examManager ? Carbon::parse($examManager->date_time)->format('jS, F Y g:i A') : null;
    
        $departmentData = [
            'name' => $department->name,
            'description' => $department->description,
            'exam_manager' => $examManager ? [
                'exam_subjects' => $examManager->exam_subject,
                'date_time' => $formattedDateTime, // Formatted date_time
                'venue' => $examManager->venue,
            ] : null,
            // Add other department details you want to return
        ];
    
    
        return response()->json($departmentData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
