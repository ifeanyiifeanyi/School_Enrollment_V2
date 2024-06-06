<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faculty;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Department;
use App\Models\Application;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmailSetRequest;
use App\Models\AcademicSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;


class DashboardController extends Controller
{
    public function index()
    {

        $academicSession = AcademicSession::where('status', 'current')->first();

        $studentCount = Student::count();
        $departmentCount = Department::count();
        $facultyCount = Faculty::count();
        $activeApplication = Application::count();
        $applicationsByDepartment = Application::select('department_id', DB::raw('count(*) as total'))
            ->groupBy('department_id')
            ->get();

        // Calculate percentage for number of student that applied to each department
        $departmentData = $applicationsByDepartment->map(function ($item) use ($activeApplication) {
            $item->percentage = $activeApplication > 0 ? ($item->total / $activeApplication) * 100 : 0;
            return $item;
        });

        $applicationsByFaculty = Application::join('departments', 'applications.department_id', '=', 'departments.id')
            ->select('departments.faculty_id', DB::raw('count(*) as total'))
            ->groupBy('departments.faculty_id')
            ->get();

        // Fetch faculty names and calculate percentages
        $facultyData = $applicationsByFaculty->map(function ($item) use ($activeApplication) {
            $faculty = Faculty::find($item->faculty_id); // Assuming you have a Faculty model
            $item->faculty_name = $faculty->name; // Assuming there's a 'name' column in faculties
            $item->percentage = $activeApplication > 0 ? ($item->total / $activeApplication) * 100 : 0;
            return $item;
        });


        // display view for payment options used per transaction
        $totalPayments = Payment::count();
        $paymentsByMethod = Payment::select('payment_method', DB::raw('count(*) as total'))
            ->groupBy('payment_method')
            ->get();

        // Calculate percentage
        $paymentData = $paymentsByMethod->map(function ($item) use ($totalPayments) {
            $item->percentage = $totalPayments > 0 ? ($item->total / $totalPayments) * 100 : 0;
            return $item;
        });
        // dd($departmentData);



        // dd($paymentTransactions);
        return view('admin.dashboard', compact(
            'studentCount',
            'activeApplication',
            'departmentCount',
            'facultyCount',
            'departmentData',
            'facultyData',
            'paymentData',
            'totalPayments',
            'academicSession'
        ));
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function siteSettings()
    {
        $siteSetting = SiteSetting::first();

        return view('admin.siteSetting.index', [
            'smtp_host' => env('MAIL_HOST'),
            'smtp_port' => env('MAIL_PORT'),
            'smtp_username' => env('MAIL_USERNAME'),
            'smtp_password' => env('MAIL_PASSWORD'),
            'encryption' => env('MAIL_ENCRYPTION'),
            'siteSetting' => $siteSetting,

            'flw_public_key' => env('FLW_PUBLIC_KEY'),
            'flw_secret_key' => env('FLW_SECRET_KEY'),
            'flw_secret_hash' => env('FLW_SECRET_HASH'),

            'paystack_secret_key' => env('PAYSTACK_SECRET_KEY'),
            'paystack_public_key' => env('PAYSTACK_PUBLIC_KEY'),
            'merchant_email' => env('MERCHANT_EMAIL'),
        ]);
    }

    public function siteSettingStore(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'site_title' => 'required|string',
                'site_color' => 'nullable|string',
                'form_price' => 'required|numeric',
                'site_description' => 'nullable|string',
                'google_analytics_code' => 'nullable|string',
                'phone' => 'nullable|string',
                'email' => 'required|email',
                'address' => 'nullable|string',
                'about' => 'nullable|string',
                'site_logo' => 'required|image|mimes:jpeg,png,jpg,svg|max:10000',
                'site_favicon' => 'required|image|mimes:jpeg,png,jpg,svg|max:10000',
            ]);

            $site = SiteSetting::firstOrNew([]);

            if ($request->hasFile('site_logo')) {
                $file = $request->file('site_logo');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('site/'), $filename);
                $site->site_icon = 'site/' . $filename;
            }

            if ($request->hasFile('site_favicon')) {
                $file = $request->file('site_favicon');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('site/'), $filename);
                $site->site_favicon = 'site/' . $filename;
            }

            $site->site_title = $request->site_title;
            $site->site_color = $request->site_color;
            $site->site_description = $request->site_description;
            $site->form_price = $request->form_price;
            $site->phone = $request->phone;
            $site->email = $request->email;
            $site->address = $request->address;
            $site->about = $request->about;
            $site->google_analytics = $request->google_analytics_code;
            $site->save();

            return response()->json(['message' => 'Site Settings Created!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }



    public function emailSetup(EmailSetRequest $request)
    {
        $validatedData = $request->validated();

        $envPath = base_path('.env');

        if (!File::exists($envPath)) {
            return response()->json(['error' => '.env file not found'], 404);
        }

        $envContent = File::get($envPath);

        // Backup the original content in case something goes wrong
        $backupEnvPath = base_path('.env.backup');
        File::put($backupEnvPath, $envContent);

        // Update the email connection params in the .env file
        $newEnvContent = preg_replace('/^MAIL_HOST=.*/m', 'MAIL_HOST=' . $validatedData['smtp_host'], $envContent);
        $newEnvContent = preg_replace('/^MAIL_PORT=.*/m', 'MAIL_PORT=' . $validatedData['smtp_port'], $newEnvContent);
        $newEnvContent = preg_replace('/^MAIL_USERNAME=.*/m', 'MAIL_USERNAME=' . $validatedData['smtp_username'], $newEnvContent);
        $newEnvContent = preg_replace('/^MAIL_PASSWORD=.*/m', 'MAIL_PASSWORD=' . $validatedData['smtp_password'], $newEnvContent);
        $newEnvContent = preg_replace('/^MAIL_ENCRYPTION=.*/m', 'MAIL_ENCRYPTION=' . $validatedData['encryption'], $newEnvContent);

        if (strlen($newEnvContent) > 0) {
            File::put($envPath, $newEnvContent);
        } else {
            // Restore the backup if something goes wrong
            File::put($envPath, File::get($backupEnvPath));
            return response()->json(['error' => 'Failed to update .env file'], 500);
        }

        // Clear the cache
        Artisan::call('config:cache');
        Artisan::call('config:clear');

        return response()->json(['message' => 'Email Settings Created!']);
    }



    public function storeFlutterwaveSettings(Request $request)
    {
        $request->validate([
            'flw_public_key' => 'required|string',
            'flw_secret_key' => 'required|string',
            'flw_secret_hash' => 'required|string',
        ]);

        $this->updateEnv([
            'FLW_PUBLIC_KEY' => $request->flw_public_key,
            'FLW_SECRET_KEY' => $request->flw_secret_key,
            'FLW_SECRET_HASH' => $request->flw_secret_hash,
        ]);

        return response()->json(['message' => 'Flutterwave settings updated successfully!']);
    }

    public function storePaystackSettings(Request $request)
    {
        $request->validate([
            'paystack_public_key' => 'required|string',
            'paystack_secret_key' => 'required|string',
            'merchant_email' => 'required|email',
        ]);

        $this->updateEnv([
            'PAYSTACK_PUBLIC_KEY' => $request->paystack_public_key,
            'PAYSTACK_SECRET_KEY' => $request->paystack_secret_key,
            'MERCHANT_EMAIL' => $request->merchant_email,
        ]);

        return response()->json(['message' => 'Paystack settings updated successfully!']);
    }

    protected function updateEnv(array $data)
    {
        $envFile = base_path('.env');
        $str = file_get_contents($envFile);

        $envLines = explode("\n", $str);
        foreach ($data as $key => $value) {
            $keyExists = false;
            foreach ($envLines as $index => $line) {
                if (strpos($line, $key . '=') === 0) {
                    $envLines[$index] = $key . '=' . $value;
                    $keyExists = true;
                    break;
                }
            }
            if (!$keyExists) {
                $envLines[] = $key . '=' . $value;
            }
        }

        $str = implode("\n", $envLines);
        file_put_contents($envFile, $str);
    }
}
