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
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

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
            'totalPayments'
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
        return view('admin.siteSetting.index');
    }

    public function siteSettingStore(Request $request)
    {
        $request->validate([
            'site_title' => 'nullable|string',
            'site_color' => 'nullable|string',
            'form_price' => 'nullable|numeric',
            'site_description' => 'nullable|string',
            'google_analytics_code' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'about' => 'nullable|string',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:10000',
            'site_favicon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:10000',
        ]);

        $site = SiteSetting::firstOrNew();

        if ($request->hasFile('site_logo')) {
            $thumb = $request->file('site_logo');
            $extension = $thumb->getClientOriginalExtension();
            $profilePhoto = time() . "." . $extension;
            $thumb->move('site/', $profilePhoto);
            $site->site_icon = 'site/' . $profilePhoto;
        }

        if ($request->hasFile('site_favicon')) {
            $thumb = $request->file('site_favicon');
            $extension = $thumb->getClientOriginalExtension();
            $profilePhoto = time() . "." . $extension;
            $thumb->move('site/', $profilePhoto);
            $site->site_favicon = 'site/' . $profilePhoto;
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

        $notification = [
            'message' => 'Site Settings Created!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
}
