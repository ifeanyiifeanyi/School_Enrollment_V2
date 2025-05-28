<?php

namespace App\Http\Controllers\Student;

use App\Models\Faculty;
use App\Models\Department;
use App\Models\AcademicSession;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentDashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        // Get current academic session
        $currentSession = AcademicSession::where('status', 'current')->first();

        // Get application for CURRENT session only
        $application = $user->applications()
            ->where('academic_session_id', $currentSession->id ?? null)
            ->first();

        // Generate URL to the student details page
        $barcodeUrl = route('student.details.show', ['nameSlug' => $user->nameSlug]);

        $faculties = Faculty::has('departments')
            ->with('departments')
            ->simplePaginate(15);

        $showPaymentAlert = false;
        $showApplicationForm = true;
        $hasCompletedApplication = false;

        // Check if user has completed application for current session
        if ($application) {
            if ($application->payment_id) {
                // Application is complete for current session
                $hasCompletedApplication = true;
                $showApplicationForm = false;
            } else {
                // Application exists but payment is pending for current session
                $showPaymentAlert = true;
                $showApplicationForm = false;
            }
        }

        // Check if user has been APPROVED (admitted) in any previous session
        $hasBeenAdmitted = $user->applications()
            ->where('admission_status', 'approved')
            ->where('academic_session_id', '!=', $currentSession->id ?? null)
            ->exists();

        // If user has been admitted before, they shouldn't see application form
        if ($hasBeenAdmitted && !$application) {
            $showApplicationForm = false;
        }

        // Additional check: If user has pending application from previous session that was denied
        // they should be able to apply again in the current session
        // $hasDeniedApplication = $user->applications()
        //     ->where('admission_status', 'denied')
        //     ->where('academic_session_id', '!=', $currentSession->id ?? null)
        //     ->exists();
        $hasDeniedApplication = $user->applications()
            ->whereIn('admission_status', ['denied', 'pending'])
            ->where('academic_session_id', '!=', $currentSession->id ?? null)
            ->exists();

        // If user was denied in previous session and has no application in current session,
        // they can apply again
        if ($hasDeniedApplication && !$application) {
            $showApplicationForm = true;
        }

        return view('student.dashboard', compact(
            'showPaymentAlert',
            'showApplicationForm',
            'hasCompletedApplication',
            'hasBeenAdmitted',
            'faculties',
            'application',
            'user',
            'barcodeUrl',
            'currentSession'
        ));
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
     * Remove the specified resource from storage.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        return redirect('/');
    }
}
