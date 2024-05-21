<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ManageAdminController extends Controller
{
    public function index()
    {
        $admins = User::with('admin')->where('role', 'admin')->get();
        // dd($admins);
        return view('admin.manageAdmin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.manageAdmin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'other_names' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'other_names' => $request->other_names,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'nameSlug' => $request->first_name . '' . $request->last_name,
            'email_verified_at' => now(),
        ]);
        $adminData = [
            'user_id' => $user->id,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->hasFile('photo')) {
            $photoFile = $request->file('photo');
            $filename = time() . '.' . $photoFile->getClientOriginalExtension();
            $photoFile->move(public_path('admin/profile'), $filename);
            $adminData['photo'] = 'admin/profile/' . $filename;
        }


        Admin::create($adminData);
        $notification = [
            'message' => 'New Administrator Created!',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.manage.admin')->with($notification);
    }
    public function edit($slug)
    {
        $admin = User::where('nameSlug', $slug)->first();
        return view('admin.manageAdmin.edit', compact('admin'));
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'first_name' => 'required|string',
            'other_names' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|email',
            'password' => 'nullable|string|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
        ]);

        $user = User::where('nameSlug', $slug)->first();
        $user->update([
            'first_name' => $request->first_name,
            'other_names' => $request->other_names,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role' => 'admin',
        ]);


        $adminData = [
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->hasFile('photo')) {
            $old_image = $user->admin->created_at;

            if (!empty($old_image) && file_exists(public_path($old_image))) {
                unlink(public_path($old_image));
            }
            $photoFile = $request->file('photo');
            $filename = time() . '.' . $photoFile->getClientOriginalExtension();
            $photoFile->move(public_path('admin/profile'), $filename);
            $adminData['photo'] = 'admin/profile/' . $filename;
        }

        $user->admin->update($adminData);

        $notification = [
            'message' => 'Administrator Updated Successfully!',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.manage.admin')->with($notification);
    }

    public function show(User $user)
    {
        $user->load('roles'); // Eager load the roles relationship
        return view('admin.manageAdmin.show', compact('user'));
    }

    public function delete(User $user)
    {
        // Check if the logged-in user is trying to delete their own profile
        if (auth()->id() == $user->id) {
            $notification = [
                'message' => 'You cannot delete your own profile!',
                'alert-type' => 'error'
            ];
            return redirect()->route('admin.manage.admin')->with($notification);
        }
        if ($user->admin->photo) {
            $old_image = $user->admin->photo;

            if (!empty($old_image) && file_exists(public_path($old_image))) {
                unlink(public_path($old_image));
            }
        }
        if ($user->delete()) {
            $user->admin->delete();
        }
        $notification = [
            'message' => 'Administrator Deleted!',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.manage.admin')->with($notification);
    }




}
