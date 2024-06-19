<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Student;
use Barryvdh\DomPDF\PDF;
use App\Models\Department;
use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ApplicationsExport;
use App\Exports\ExportAllStudents;
use App\Imports\ApplicationsImport;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class StudentManagementController extends Controller
{
    // display all students
    public function index()
    {
        $students = User::with(['applications' => function ($query) {
            $query->select('applications.*', 'departments.name as department_name')
                ->join('departments', 'applications.department_id', '=', 'departments.id');
        }])
            ->where('role', 'student')
            ->simplePaginate(100);

        // $students = User::with(['applications' => function ($query) {
        //     $query->select('applications.*', 'departments.name as department_name')
        //         ->join('departments', 'applications.department_id', '=', 'departments.id')
        //         ->whereNotNull('applications.payment_id') // Filter out applications with null or empty payment_id
        //         ->where('applications.payment_id', '!=', '');
        // }])
        //     ->where('role', 'student')
        //     ->simplePaginate(100);

        // $students = User::where('role', 'student')->simplePaginate('100');
        // dd($students);
        return view('admin.studentManagement.index', compact('students'));
    }

    // export all students to excel
    public function exportAllStudents(){
        return Excel::download(new ExportAllStudents(), 'all_students.xlsx');

    }

    /**
     * Undocumented function
     *
     * @param [type] $slug
     * @return void
     *
     * SHOW STUDENT DETAILS, AFTER SUBMITTING APPLICATION,
     * student application data
     */
    public function show($slug)
    {
        $student = User::with(['applications' => function ($query) {
            $query->select('applications.*', 'departments.name as department_name')
                ->join('departments', 'applications.department_id', '=', 'departments.id');
        }])
            ->where('role', 'student')
            ->where('nameSlug', $slug)
            ->first();

        $documentKeys = [
            'birth_certificate' => 'document_birth_certificate',
            'local_government_identification' => 'document_local_government_identification',
            'medical_report' => 'document_medical_report',
            'secondary_school_certificate' => 'document_secondary_school_certificate_type'
        ];

        $documents = [];
        foreach ($documentKeys as $label => $key) {
            $filename = $student->student->$key;
            if ($filename) { // Corrected path check
                $filePath = asset($filename); // Corrected URL generation
                $isPdf = Str::endsWith($filename, '.pdf');
                $documents[$label] = [
                    'filePath' => $filePath,
                    'isPdf' => $isPdf,
                    'exists' => true
                ];
            } else {
                $documents[$label] = [
                    'exists' => false
                ];
            }
        }
        // dd($documents);


        return view('admin.studentManagement.show', compact('student', 'documents'));
    }


    // HANDLE STUDENTS THAT HAS APPLIED FOR ADMISSION (successfully)
    public function application(Request $request)
    {
        $departments = Department::latest()->get();
        $departmentId = $request->input('department_id');

        if ($departmentId) {
            $applications = Application::with(['user.student', 'department', 'academicSession'])
                ->where('department_id', $departmentId)
                ->whereNotNull('payment_id') // Ensure payment_id is not null
                ->where('payment_id', '!=', '') // Ensure payment_id is not empty
                ->simplePaginate(100);
        } else {
            $applications = Application::with(['user.student', 'department', 'academicSession'])
                ->whereNotNull('payment_id') // Ensure payment_id is not null
                ->where('payment_id', '!=', '') // Ensure payment_id is not empty
                ->simplePaginate(100);
        }

        return view('admin.studentManagement.application', compact('applications', 'departments'));
    }




    public function applicationRef(Request $request)
    {
        $departments = Department::latest()->get();
        $departmentId = $request->input('department_id');

        if ($departmentId) {
            $applications = Application::with(['user.student', 'department'])->whereNotNull('payment_id')
                ->where('department_id', $departmentId)
                ->simplePaginate(50);
        } else {
            $applications = Application::with(['user.student', 'department', 'academicSession'])
            ->whereNotNull('payment_id')
            ->simplePaginate(50);
        }

        return view('admin.studentManagement.applicationRef', compact('applications', 'departments'));
    }



    public function exportPdf(Request $request)
    {
        $departments = Department::latest()->get();
        $departmentId = $request->input('department_id');
        $query = Application::with(['user.student', 'department']);

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        $applications = $query->get(); // Retrieve all applications for PDF export

        // Load a separate view specifically for the PDF export
        $pdf = FacadePdf::loadView('admin.studentManagement.pdfView', compact('applications', 'departments'));

        return $pdf->download('applications.pdf');
    }






    public function exportApplications(Request $request)
    {
        $departmentId = $request->input('department_id');
        return Excel::download(new ApplicationsExport($departmentId), 'applications.xlsx');
    }



    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);
        $file = $request->file('file');


        Excel::import(new ApplicationsImport, $file);
        $notification = [
            'message' => 'File Import Was Successful!!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }


    // edit admin account details
    public function edit($slug)
    {
        $path = public_path('countries.json');
        if (!File::exists($path)) {
            abort(404, 'file not found');
        }
        $json = File::get($path);
        $countries = json_decode($json, true);
        $user = User::where('nameSlug', $slug)->firstOrFail();
        // dd($user);
        return view('admin.studentManagement.edit', compact('user', 'countries'));
    }


    // update admin account details
    public function update(Request $request, $slug)
    {
        $user = User::where('nameSlug', $slug)->firstOrFail();
        $application = $user->applications->first();

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string',
            'jamb_reg_no' => 'nullable|string',
            'jamb_score' => 'nullable|numeric',
            'religion' => 'nullable|string',
            'nin' => 'nullable|string',
            'dob' => 'required|date',
            'current_residence_address' => 'nullable|string',
            'country_of_origin' => 'required|string',
            'blood_group' => 'nullable|string',
            'genotype' => 'nullable|string',
            'gender' => 'nullable|string',
            'exam_score' => 'nullable|numeric',
            'admission_status' => 'nullable|in:denied,pending,approved',
            'passport_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:1000',
        ]);

        if ($request->hasFile('passport_photo')) {
            $old_image = $user->passport_passport_photo;

            if (!empty($old_image) && file_exists(public_path($old_image))) {
                unlink(public_path($old_image));
            }

            $thumb = $request->file('passport_photo');
            $user->student->passport_photo =  $this->storeFile($thumb, 'public/photos');
        }

        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'other_names' => $request->input('other_names'),
            'email' => $request->input('email')
        ]);

        $user->student->update([
            'phone' => $request->input('phone'),
            'nin' => $request->input('nin'),
            'dob' => $request->input('dob'),
            'blood_group' => $request->input('blood_group'),
            'genotype' => $request->input('genotype'),
            'gender' => $request->input('gender'),
            'phone' => $request->input('phone'),
            'jamb_reg_no' => $request->input('jamb_reg_no'),
            'jamb_score' => $request->input('jamb_score'),
            'religion' => $request->input('religion'),
            'country_of_origin' => $request->input('country_of_origin'),
            'current_residence_address' => $request->input('current_residence_address'),
            'permanent_residence_address' => $request->input('current_residence_address'),
            'nationality' => $request->input('country_of_origin'),
        ]);

        if ($application) {
            $application->update([
                'admission_status' => $request->input('admission_status'),
            ]);

            $application->student->update([
                'exam_score' => $request->input('exam_score'),
            ]);
        }
        $notification = [
            'message' => 'Details Updated!!!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.student.management')->with($notification);
    }

    // delete multiple students at once
    public function deleteMultipleStudents(Request $request)
    {
        $userIds = $request->input('selected_students'); // These are user IDs.

        DB::transaction(function () use ($userIds) {
            $students = Student::whereIn('user_id', $userIds)->get();

            foreach ($students as $student) {
                // List of document columns to check and potentially delete
                $documentFields = [
                    'document_local_government_identification',
                    'document_medical_report',
                    'document_secondary_school_certificate'
                ];

                // Delete passport photo if it exists
                if ($student->passport_photo && file_exists(public_path($student->passport_photo))) {
                    unlink(public_path($student->passport_photo));
                }

                // Check and delete each document if it exists
                foreach ($documentFields as $field) {
                    if ($student->$field && file_exists(public_path($student->$field))) {
                        unlink(public_path($student->$field));
                    }
                }

                // Delete the student record
                $student->delete();
            }

            // Delete users associated with these student records
            User::whereIn('id', $userIds)->delete();
        });

        $notification = [
            'message' => 'Students deleted successfully!!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }


    // delete single student
    public function destroy($slug)
    {
        DB::transaction(function () use ($slug) {
            $user = User::where('nameSlug', $slug)->firstOrFail(); // Find the user by slug

            $student = $user->student; // Assuming there is a 'student' relationship defined in the User model

            // Check and delete files associated with the student
            $filesToDelete = [
                $student->passport_photo,
                $student->document_local_government_identification,
                $student->document_secondary_school_certificate
            ];

            foreach ($filesToDelete as $filePath) {
                if ($filePath && file_exists(public_path($filePath))) {
                    unlink(public_path($filePath));
                }
            }

            // Delete the student record
            $student->delete();

            // Optionally delete the user if required
            $user->delete();
        });

        $notification = [
            'message' => 'Student deleted successfully!!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }



    protected function storeFile($file, $directory)
    {
        if ($file) {
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs($directory, $filename);
            return $path;
        }

        return null;
    }
}
