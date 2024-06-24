<?php

namespace App\Http\Controllers\Student;

use App\Models\User;
use App\Models\Student;
use App\Models\Department;
use App\Models\Application;
use App\Models\ExamSubject;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AcademicSession;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Mail\RegistrationConfirmationMail;
use Intervention\Image\Laravel\Facades\Image;

class StudentAdmissionApplicationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $application = $user->applications->first();
        if ($application && is_null($application->payment_id)) {
            // Application form has been filled, but payment is pending
            $notification = [
                'message' => 'Please complete the payment to finalize your application.',
                'alert-type' => 'info'
            ];
            return redirect()->route('payment.view.finalStep', ['userSlug' => $user->nameSlug])->with($notification);
        }


        $religions = config('app_data.religions');
        $nigerianStates = config('app_data.nigerianStates');
        $localGovernments = config('app_data.localGovernments');

        $departments = Department::all();
        $departmentDescriptions = $departments->pluck('description', 'id');
        $examSubjects = ExamSubject::pluck('name', 'name');
        $countries = $this->getCountries();
        $academicSession = AcademicSession::where('status', 'current')->first();

        return view('student.admissionPortal.index', compact(
            'examSubjects',
            'countries',
            'departments',
            'academicSession',
            'religions',
            'nigerianStates',
            'localGovernments',
            'departmentDescriptions'
        ));
    }



    protected function getCountries()
    {
        $path = public_path('countries.json');
        if (File::exists($path)) {
            $json = File::get($path);
            $countriesData = json_decode($json, true);
            return array_map(function ($country) {
                return $country['name'];
            }, $countriesData);
        }
        return [];
    }


    public function submitAdmissionApplication(Request $request)
    {


        // General validation rules
        $rules = [
            'first_name' => 'required|string',
            'blood_group' => 'required|string',
            'genotype' => 'required|string',
            'last_name' => 'required|string',
            'other_names' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'gender' => 'required|string',
            'religion' => 'required|string',
            'dob' => 'required|date',
            'nin' => 'required|string',
            'current_residence_address' => 'required|string',
            'permanent_residence_address' => 'required|string',
            'guardian_name' => 'required|string',
            'guardian_phone_number' => 'required|string',
            'guardian_address' => 'required|string',
            'country' => 'required|string',
            'marital_status' => 'required|string',
            'secondary_school_attended' => 'required|string',
            'secondary_school_graduation_year' => 'required|date',
            'secondary_school_certificate_type' => 'required|string',
            'jamb_reg_no' => 'required|string',
            'jamb_score' => 'required|numeric',
            'jamb_selection' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'academic_session_id' => 'required|exists:academic_sessions,id',
            'passport_photo' => 'required|image|mimes:jpeg,jpg,png|max:10048',
            'document_ssce' => 'required|image|mimes:jpeg,jpg,png|max:10048',
            // 'document_jamb' => 'required|image|mimes:jpeg,jpg,png|max:10048',
            'terms' => 'accepted',
        ];

        // Add custom validation rules based on the country
        if ($request->country == 'Nigeria') {

            $rules['state_of_origin_nigeria'] = 'required|string';
            $rules['localGovernment'] = 'required|string';
        } else {
            $rules['state_of_origin'] = 'required|string';
            $rules['lga_origin'] = 'required|string';
        }

        $request->validate($rules);


        try {

            $studentData = $request->only([
                'phone', 'gender', 'marital_status', 'jamb_selection', 'dob', 'religion', 'nin', 'state_of_origin', 'lga_origin', 'current_residence_address', 'permanent_residence_address',
                'guardian_name', 'guardian_phone_number', 'guardian_address', 'secondary_school_attended',
                'secondary_school_graduation_year', 'secondary_school_certificate_type', 'jamb_reg_no',
                'jamb_score', 'blood_group', 'genotype'
            ]);


            if ($request->country == 'Nigeria') {
                $studentData['state_of_origin'] = $request->state_of_origin_nigeria;
                $studentData['lga_origin'] = $request->localGovernment;
            }else{
                $studentData['state_of_origin'] = $request->state_of_origin;
                $studentData['lga_origin'] = $request->lga_origin;
            }
            // dd($request);


            $user = User::where('id', auth()->user()->id)->firstOrFail();

            $user->update($request->only('first_name', 'last_name', 'other_names', 'email'));



            // File upload handling
            $studentData['passport_photo'] = $this->storeFile($request->file('passport_photo'), 'uploads/passport_photos');
            $studentData['document_secondary_school_certificate_type'] = $this->storeFile($request->file('document_ssce'), 'uploads/ssce_documents');
            // $studentData['document_local_government_identification'] = $this->storeFile($request->file('document_jamb'), 'uploads/jamb_documents');

            $studentData['application_unique_number'] = $this->generateUniqueNumber();
            $studentData['nationality'] = $request->country;
            $studentData['country_of_origin'] = $request->country;

            $user->student()->updateOrCreate(['user_id' => $user->id], $studentData);

            $application = Application::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'department_id' => $request->department_id,
                    'academic_session_id' => $request->academic_session_id,
                    'invoice_number' => mt_rand(100000, 999999)
                ]
            );

            Mail::to($user->email)->send(new RegistrationConfirmationMail($user, $application));

            return redirect()->route('payment.view.finalStep', ['userSlug' => Str::slug($user->nameSlug)]);
            
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error in submitting admission application: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all(),
            ]);



            // Redirect back with an error message
            return redirect()->back()->withInput()->withErrors(['error' =>  $e->getMessage()]);
        }
    }


    protected function storeFile($file, $directory)
    {
        if ($file) {
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();

            // Get the path
            $path = public_path($directory);

            // // Check if the directory exists, and if not, return null or handle accordingly
            // if (!File::exists($path)) {
            //     // Handle the case where the directory does not exist (return null or log the error)
            //     return null;
            // }

            // Save the image
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($file->getRealPath());
            $image->save($path . '/' . $filename);

            return $directory . '/' . $filename;
        }

        return null;
    }


    protected function generateUniqueNumber()
    {
        $lastRegisteredPerson = Student::max('id') + 1;
        return 'SHN' . mt_rand(1000000, 9999999) . $lastRegisteredPerson;
    }
}
