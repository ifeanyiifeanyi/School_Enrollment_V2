<?php

namespace App\Http\Controllers\Student;

use App\Models\User;
use App\Models\Admin;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function profile()
    {
        $user = auth()->user();
        $application = $user->applications->first();

        $hasPendingApplication = $application ? $application->admission_status === 'pending' : false;

        return view('student.profile.index', ['user' => $user, 'application' => $application, 'hasPendingApplication' => $hasPendingApplication]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function setPassword()
    {
        return view('student.profile.setPassword');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|confirmed|different:current_password|min:8|max:10'
        ]);

        $user = User::find(Auth::user()->id);

        // if (Hash::check($user->password, $request->password)) {
        //     return redirect()->back()->withErrors('password', 'New password cannot be the same as your current password');
        // }

        $user->update([
            'password' => bcrypt($request->password)
        ]);
        $notification = [
            'message' => 'Password Details Updated!',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
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
    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $student = Student::where('user_id', $user->id);

        $request->validate([
            'first_name' =>'required|string',
            'last_name' =>'required|string',
            'other_names' =>'required|string',
            'email' =>'required|email',
            'gender' =>'required|string',
            'religion' =>'required|string',
            'dob' =>'required|date',
            'current_residence_address' =>'required|string',
            'permanent_residence_address' =>'required|string',
            'secondary_school_attended' =>'required|string',
            'secondary_school_graduation_year' =>'required|date',
            'phone' =>'required|string'
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'other_names' => $request->other_names,
            'email' => $request->email
        ]);


        $student->update([
            'phone' => $request->phone,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'dob' => $request->dob,
            'current_residence_address' => $request->current_residence_address,
            'permanent_residence_address' => $request->permanent_residence_address,
            'secondary_school_attended' => $request->secondary_school_attended,
            'secondary_school_graduation_year' => $request->secondary_school_graduation_year
        ]);



        $notification = [
            'message' => 'Profile Details Updated!',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
