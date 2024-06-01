<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ScholarApplication;
use App\Exports\ApplicationsExport;
use App\Imports\ApplicationsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
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
        $application = ScholarApplication::with('user', 'scholarship', 'answers')->find($id);
        if (!$application) {
            return redirect()->back();
        }
        return view('admin.scholarshipApplication.details', compact('application'));
    }
}
