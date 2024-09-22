<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Payment;
use App\Models\Student;
use Barryvdh\DomPDF\PDF;
use App\Models\Department;
use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\ExportAllStudents;
use Illuminate\Support\Facades\DB;
use App\Exports\ApplicationsExport;
use App\Imports\ApplicationsImport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\ApplicationRejectedMail;
use Illuminate\Support\Facades\Storage;
use App\Mail\ApplicationApprovedMailAdmin;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use App\Mail\AdmissionStatusUpdated;

class StudentManagementController extends Controller
{

    // display all students
    public function index()
    {
        $activeApplication = Application::whereNotNull('payment_id')->count();

        $verifiedStudentsCount = Student::whereHas('user', function ($query) {
            $query->whereNotNull('email_verified_at');
        })->count();


        // $students = User::with(['applications' => function ($query) {
        //     $query->select('applications.*', 'departments.name as department_name')
        //         ->join('departments', 'applications.department_id', '=', 'departments.id');
        // }])
        //     ->where('role', 'student')
        //     ->simplePaginate(100);

        // Order users by their account creation date
        $students = User::with(['applications' => function ($query) {
            $query->select('applications.*', 'departments.name as department_name')
                ->join('departments', 'applications.department_id', '=', 'departments.id');
        }])
            ->where('role', 'student')
            ->orderBy('created_at', 'desc') // Order by user creation date
            ->simplePaginate(100);


        return view('admin.studentManagement.index', compact(
            'students',
            'activeApplication',
            'verifiedStudentsCount'
        ));
    }

    // public function search(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $query = $request->get('query');
    //         $students = User::with(['applications' => function ($query) {
    //             $query->select('applications.*', 'departments.name as department_name')
    //                 ->join('departments', 'applications.department_id', '=', 'departments.id');
    //         }])
    //             ->where('role', 'student')
    //             ->where(function ($q) use ($query) {
    //                 $q->where('first_name', 'LIKE', "%{$query}%")
    //                     ->orWhere('last_name', 'LIKE', "%{$query}%")
    //                     ->orWhere('other_names', 'LIKE', "%{$query}%")
    //                     ->orWhereHas('student', function ($subQuery) use ($query) {
    //                         $subQuery->where('phone', 'LIKE', "%{$query}%");
    //                     });
    //             })
    //             ->orderBy('created_at', 'desc')
    //             ->get();

    //         return response()->json(view('admin.partials.studentTableBody', compact('students'))->render());
    //     }
    // }


    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            $students = User::with(['applications' => function ($query) {
                $query->select('applications.*', 'departments.name as department_name')
                    ->join('departments', 'applications.department_id', '=', 'departments.id');
            }])
                ->where('role', 'student')
                ->where(function ($q) use ($query) {
                    $q->where('first_name', 'LIKE', "%{$query}%")
                        ->orWhere('last_name', 'LIKE', "%{$query}%")
                        ->orWhere('other_names', 'LIKE', "%{$query}%")
                        ->orWhereRaw("CONCAT(IFNULL(first_name, ''), ' ', IFNULL(last_name, ''), ' ', IFNULL(other_names, '')) LIKE ?", ["%{$query}%"])
                        ->orWhereHas('student', function ($subQuery) use ($query) {
                            $subQuery->where('phone', 'LIKE', "%{$query}%");
                        });
                })
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json(view('admin.partials.studentTableBody', compact('students'))->render());
        }
    }


    // export all students to excel
    public function exportAllStudents()
    {
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
        $student = User::with(['applications.department'])
            ->where('role', 'student')
            ->where('nameSlug', $slug)
            ->firstOrFail();

        $documentKeys = [
            'birth_certificate' => 'document_birth_certificate',
            'local_government_identification' => 'document_local_government_identification',
            'medical_report' => 'document_medical_report',
            'secondary_school_certificate' => 'document_secondary_school_certificate_type'
        ];

        $documents = [];
        foreach ($documentKeys as $label => $key) {
            $filename = $student->student->$key;
            if ($filename) {
                if ($filename === 'awaiting') {
                    $documents[$label] = [
                        'awaiting' => true
                    ];
                } else {
                    $filePath = asset($filename);
                    $isPdf = Str::endsWith($filename, '.pdf');
                    $documents[$label] = [
                        'filePath' => $filePath,
                        'isPdf' => $isPdf,
                        'exists' => true
                    ];
                }
            } else {
                $documents[$label] = [
                    'exists' => false
                ];
            }
        }

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
                ->whereNotNull('payment_id')
                ->where('payment_id', '!=', '')
                ->orderBy('created_at', 'desc')
                ->distinct() // Ensure only distinct records are fetched
                ->paginate(100); // Use pagination
        } else {
            $applications = Application::with(['user.student', 'department', 'academicSession'])
                ->whereNotNull('payment_id')
                ->where('payment_id', '!=', '')
                ->orderBy('created_at', 'desc')
                ->distinct() // Ensure only distinct records are fetched
                ->paginate(100); // Use pagination
        }

        return view('admin.studentManagement.application', compact('applications', 'departments'));
    }

    // this function is used for managing students that their application
    // needs to be processed manually
    // 1.
    public function pendingApprovals()
    {
        $pendingApplications = Application::with(['user.student', 'department', 'payment'])
            ->where(function ($query) {
                $query->whereNull('payment_id')
                    ->orWhereHas('payment', function ($q) {
                        $q->where('payment_status', '!=', 'successful');
                    });
            })
            ->where('admission_status', 'pending')
            ->paginate(15);

        return view('admin.studentManagement.pendingApprovals', compact('pendingApplications'));
    }

    // manually approve the student application
    // 2.
    public function approveApplication(Application $application)
    {
        DB::transaction(function () use ($application) {
            // Update or create payment record
            $payment = Payment::updateOrCreate(
                ['user_id' => $application->user_id, 'transaction_id' => $application->transaction_id],
                [
                    'amount' => $application->amount ?? 0,
                    'payment_method' => $application->paymentMethod->name ?? 'Admin Approval',
                    'payment_status' => 'successful',
                    'transaction_id' => $application->transaction_id ?? 'ADMIN_' . Str::random(10),
                ]
            );

            // Update the application
            $application->update([
                'payment_id' => $payment->id,
                'admission_status' => 'pending'
            ]);
        });

        // Send approval notification to student
        // Mail::to($application->user->email)->send(new ApplicationApprovedMailAdmin($application));

        return redirect()->back()->with('success', 'Application approved successfully');
    }
    // search the pending approval table
    // 3.
    public function searchPendingApprovals(Request $request)
    {
        $query = Application::with(['user', 'department', 'payment'])
            ->where(function ($q) {
                $q->whereNull('payment_id')
                    ->orWhereHas('payment', function ($pq) {
                        $pq->where('payment_status', '!=', 'successful');
                    });
            })
            ->where('admission_status', 'pending');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('user', function ($uq) use ($searchTerm) {
                    $uq->where('first_name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('email', 'LIKE', "%{$searchTerm}%");
                })
                    ->orWhereHas('department', function ($dq) use ($searchTerm) {
                        $dq->where('name', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        $pendingApplications = $query->paginate(15)->appends($request->all());

        return view('admin.studentManagement.pendingApprovals', compact('pendingApplications'));
    }
    // reject the said applications
    // 4.
    public function rejectApplication(Application $application)
    {
        // Delete the payment record if it exists
        if ($application->payment) {
            $application->payment->delete();
        }



        // Send rejection notification to student
        Mail::to($application->user->email)->send(new ApplicationRejectedMail($application));

        // Delete the application
        $application->delete();

        return redirect()->back()->with('success', 'Application rejected and deleted');
    }


    // bulk action for approved/pending
    public function bulkAction(Request $request)
    {
        $ids = $request->input('ids');
        $action = $request->input('action');

        $applications = Application::whereIn('id', $ids)->get();

        foreach ($applications as $application) {
            if ($action === 'approve' && $application->admission_status !== 'approved') {
                $application->update(['admission_status' => 'approved']);
                $this->sendStatusUpdateEmail($application);
            } elseif ($action === 'pending' && $application->admission_status !== 'pending') {
                $application->update(['admission_status' => 'pending']);
                $this->sendStatusUpdateEmail($application);
            }
        }

        return response()->json(['message' => 'Applications updated successfully']);
    }
    // HERE WE DENY APPROVED APPLICATIONS(singular)
    // public function denyApplication(Application $application)
    // {
    //     // dd($application->user->student);
    //     if ($application->admission_status == 'approved') {
    //         $application->update(['admission_status' => 'pending']);



    //         return redirect()->back()->with([
    //             'message' => 'Application Status has been reset',
    //             'alert-type' => 'success'
    //         ]);
    //     }

    //     return redirect()->back()->with([
    //         'message' => 'Cannot deny an approved application',
    //         'alert-type' => 'error'
    //     ]);
    // }

    public function denyApplication(Application $application)
    {
        if ($application->admission_status !== 'pending') {
            $application->update(['admission_status' => 'pending']);
            $this->sendStatusUpdateEmail($application);

            return redirect()->back()->with([
                'message' => 'Application Status has been reset to Pending',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Application is already pending',
            'alert-type' => 'info'
        ]);
    }

    // HERE WE SET APPROVED APPLICATIONS(singular)
    public function approveApplicationSingle(Application $application)
    {
        if ($application->admission_status !== 'approved') {
            $application->update(['admission_status' => 'approved']);
            $this->sendStatusUpdateEmail($application);

            return redirect()->back()->with([
                'message' => 'Application Status has been updated to Approved',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Application is already approved',
            'alert-type' => 'info'
        ]);
    }

    private function sendStatusUpdateEmail(Application $application)
    {
        Mail::to($application->user->email)->send(new AdmissionStatusUpdated($application->user->student, $application));
    }



    public function ApplicationSearch(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            $applications = Application::with(['user.student', 'department', 'academicSession'])
                ->where(function ($q) use ($query) {
                    $q->whereHas('user', function ($subQ) use ($query) {
                        $subQ->where('first_name', 'LIKE', "%{$query}%")
                            ->orWhere('last_name', 'LIKE', "%{$query}%")
                            ->orWhere('other_names', 'LIKE', "%{$query}%")
                            ->orWhereRaw("CONCAT(IFNULL(first_name, ''), ' ', IFNULL(last_name, ''), ' ', IFNULL(other_names, '')) LIKE ?", ["%{$query}%"]);
                    })
                        ->orWhereHas('user.student', function ($subQ) use ($query) {
                            $subQ->where('phone', 'LIKE', "%{$query}%")
                                ->orWhere('application_unique_number', 'LIKE', "%{$query}%");
                        });
                })
                ->whereNotNull('payment_id')
                ->where('payment_id', '!=', '')
                ->orderBy('created_at', 'desc')
                ->paginate(100);

            return response()->json(view('admin.partials.applicationTableBody', compact('applications'))->render());
        }
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
        $import = new ApplicationsImport;

        try {
            Excel::import($import, $file);

            // Check for errors from the import process
            $errors = $import->getErrors();

            if (!empty($errors)) {
                session()->flash('import_errors', $errors);
            } else {
                session()->flash('success', 'Import completed successfully.');
            }

            if (!empty($errors)) {
                $notification = [
                    'message' => 'Import completed with some errors: ' . implode(', ', $errors),
                    'alert-type' => 'warning'
                ];
            } else {
                $notification = [
                    'message' => 'File Import Was Successful!!',
                    'alert-type' => 'success'
                ];
            }
        } catch (\Exception $e) {
            // Log the error if needed
            Log::error('Error during file import: ' . $e->getMessage());

            // Set the error notification message
            $notification = [
                'message' => 'Error during file import: ' . $e->getMessage(),
                'alert-type' => 'danger'
            ];
        }

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
    // public function deleteMultipleStudents(Request $request)
    // {
    //     $userIds = $request->input('selected_students'); // These are user IDs.

    //     DB::transaction(function () use ($userIds) {
    //         $students = Student::whereIn('user_id', $userIds)->get();

    //         foreach ($students as $student) {
    //             // List of document columns to check and potentially delete
    //             $documentFields = [
    //                 'document_local_government_identification',
    //                 'document_medical_report',
    //                 'document_secondary_school_certificate'
    //             ];

    //             // Delete passport photo if it exists
    //             if ($student->passport_photo && file_exists(public_path($student->passport_photo))) {
    //                 unlink(public_path($student->passport_photo));
    //             }

    //             // Check and delete each document if it exists
    //             foreach ($documentFields as $field) {
    //                 if ($student->$field && file_exists(public_path($student->$field))) {
    //                     unlink(public_path($student->$field));
    //                 }
    //             }

    //             // Delete the student record
    //             $student->delete();
    //         }

    //         // Delete users associated with these student records
    //         User::whereIn('id', $userIds)->delete();
    //     });

    //     $notification = [
    //         'message' => 'Students deleted successfully!!',
    //         'alert-type' => 'success'
    //     ];

    //     return redirect()->back()->with($notification);
    // }


    // delete single student
    public function destroy($slug)
    {
        DB::transaction(function () use ($slug) {
            $user = User::where('nameSlug', $slug)->firstOrFail(); // Find the user by slug

            // dd($user);

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
    // public function deleteMultipleStudents(Request $request)
    // {
    //     $userIds = $request->input('selected_students'); // These are user IDs.

    //     DB::transaction(function () use ($userIds) {
    //         // Get students whose user IDs match the selected ones
    //         $students = Student::whereIn('user_id', $userIds)->get();

    //         foreach ($students as $student) {
    //             // Check if the student has an application with a non-null payment_id
    //             $hasPaidApplication = $student->applications()->whereNotNull('payment_id')->exists();

    //             // Skip deletion if there's a paid application
    //             if ($hasPaidApplication) {
    //                 continue;
    //             }

    //             // List of document columns to check and potentially delete
    //             $documentFields = [
    //                 'document_local_government_identification',
    //                 'document_medical_report',
    //                 'document_secondary_school_certificate'
    //             ];

    //             // Delete passport photo if it exists
    //             if ($student->passport_photo && file_exists(public_path($student->passport_photo))) {
    //                 unlink(public_path($student->passport_photo));
    //             }

    //             // Check and delete each document if it exists
    //             foreach ($documentFields as $field) {
    //                 if ($student->$field && file_exists(public_path($student->$field))) {
    //                     unlink(public_path($student->$field));
    //                 }
    //             }

    //             // Delete the student record
    //             $student->delete();
    //         }

    //         // Delete users associated with these student records if they have no paid applications
    //         User::whereIn('id', $userIds)
    //             ->whereDoesntHave('student.applications', function ($query) {
    //                 $query->whereNotNull('payment_id');
    //             })
    //             ->delete();
    //     });

    //     $notification = [
    //         'message' => 'Students deleted successfully!',
    //         'alert-type' => 'success'
    //     ];

    //     return redirect()->back()->with($notification);
    // }

    public function unverifiedStudents()
    {
        $students = User::with('Student')->where('email_verified_at', '=', null)->simplePaginate('100');
        return view('admin.studentManagement.unverifiedStudentEmail', compact('students'));
    }

    public function verifyStudent($slug)
    {
        $student = User::where('nameSlug', $slug)->firstOrFail();
        // dd($student);
        $student->update([
            'email_verified_at' => now()
        ]);
        $notification = [
            'message' => 'Student Account verified successfully',
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
