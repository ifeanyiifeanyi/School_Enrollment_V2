<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ScholarApplication;
use Illuminate\Support\Facades\DB;
use App\Exports\ApplicationsExport;
use App\Imports\ApplicationsImport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\ScholarshipStatusChanged;
use App\Exports\ScholarshipApplicationsExport;
use App\Imports\ScholarshipApplicationsImport;

class StudentScholarshipApplicationController extends Controller
{
    public function index()
    {
        $applications = ScholarApplication::with('user', 'scholarship')->latest()->simplePaginate('100');
        return view('admin.scholarshipApplication.index', compact('applications'));
    }


    // export the scholarship applicants to excel
    public function export()
    {
        return Excel::download(new ScholarshipApplicationsExport, 'scholarship_applications.xlsx');
    }

    // import the updated excel for scholarship status management
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        Excel::import(new ScholarshipApplicationsImport, $request->file('file'));

        $notification  = [
            'message' => 'Applications imported successfully and statuses updated.',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.scholarship.applicants')->with($notification);
    }

    public function show($id)
    {
        $application = ScholarApplication::with(['user', 'scholarship', 'answers.question', 'department.faculty'])->find($id);
        // dd($application);
        if (!$application) {
            return redirect()->back();
        }
        return view('admin.scholarshipApplication.details', compact('application'));
    }

    // public function approve($id)
    // {
    //     $application = ScholarApplication::findOrFail($id);
    //     dd($application);
    //     $application->status = 'approved';
    //     $application->save();

    //     $notification = [
    //         'message' => 'Application approved successfully.',
    //         'alert-type' => 'success'
    //     ];

    //     return redirect()->route('admin.scholarship.applicants')->with($notification);
    // }

    public function approve($id)
    {
        DB::beginTransaction();
        try {
            $application = ScholarApplication::findOrFail($id);
            $oldStatus = $application->status;
            $application->status = 'approved';
            $application->save();

            if ($oldStatus != 'approved') {
                Mail::to($application->user->email)->send(new ScholarshipStatusChanged($application));
            }

            DB::commit();

            $notification = [
                'message' => 'Application approved successfully and email sent to the student.',
                'alert-type' => 'success'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error during scholarship approval: ' . $e->getMessage());

            $notification = [
                'message' => 'Error approving application: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];
        }

        return redirect()->route('admin.scholarship.applicants')->with($notification);
    }
}
