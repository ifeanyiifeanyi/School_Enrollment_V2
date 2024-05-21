<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function show(){
        $adminDetails =auth()->user();
        return view('admin.profile.show', compact('adminDetails'));
    }

    public function update(Request $request){
        $user = User::find(Auth::user()->id);
        $admin = Admin::find($user->id);

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'other_names' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
        ]);

        if ($request->hasFile('photo')) {
            $old_image = $admin->photo;

            if (!empty($old_image) && file_exists(public_path($old_image))) {
                unlink(public_path($old_image));
            }

            $thumb = $request->file('photo');
            $extension = $thumb->getClientOriginalExtension();
            $profilePhoto = time() . "." . $extension;
            $thumb->move('admin/profile/', $profilePhoto);
            $admin->photo = 'admin/profile/' . $profilePhoto;
        } elseif (empty($admin->photo)) {
            return back()->withErrors(['photo' => 'The image field is required.']);
        }

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'other_names' => $request->other_names,
            'email' => $request->email,
        ]);

        $admin->update([
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        $notification = [
            'message' => 'Profile Details Updated!',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    }

    public function setPassword(){
        return view('admin.profile.setPassword');
    }

    public function updatePassword(Request $request){
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|different:current_password'
        ]);

        $user = User::find(Auth::user()->id);

        if (Hash::check($user->password, $request->password)) {
            return redirect()->back()->withErrors('password', 'New password cannot be the same as your current password');
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);
        $notification = [
            'message' => 'Password Details Updated!',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    }
}
