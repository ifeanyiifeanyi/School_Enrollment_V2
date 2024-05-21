<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageRolePermissionController extends Controller
{
    public function index(Request $request)
    {
        $adminId = $request->query('user_id');
        $selectedAdmin = null;

        if ($adminId) {
            $selectedAdmin = User::where('role', 'admin')->find($adminId);
        }

        $admins = User::where('role', 'admin')->get();
        $roles = Role::all();

        return view('admin.manageRolePermission.index', compact('admins', 'roles', 'selectedAdmin'));
    }

    // assign roles to an admin
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $admin = User::findOrFail($validatedData['user_id']);
        $admin->roles()->sync($validatedData['roles']);
        $notification = [
            'message' => 'Roles assigned successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }


    public function createPermission()
    {
        $permissions = Permission::latest()->get();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);



        Permission::create(['name' => Str::slug($request->name)]);

        $notification = [
            'message' => 'Permission Created successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }



    public function createRole()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    public function storeRole(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Create a new role
        $newRole = new Role();
        $newRole->name = $validatedData['name'];
        $newRole->save();

        // Assign permissions to the new role
        $permissions = Permission::whereIn('id', $validatedData['permissions'])->get();
        $newRole->permissions()->attach($permissions);

        // Ensure the admin role has all permissions, including the new ones
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $allPermissions = Permission::all(); // Get all permissions
            $adminRole->permissions()->sync($allPermissions->pluck('id')->toArray());
        }

        // Prepare the success notification
        $notification = [
            'message' => 'New Role Created successfully!',
            'alert-type' => 'success'
        ];

        // Redirect back with the notification
        return redirect()->back()->with($notification);
    }


    public function viewRoles(){
        $roles = Role::with('permissions')->simplePaginate('5');
        return view('admin.roles.view', compact('roles'));

    }

    public function viewPermission(){
        $permissions = Permission::with('roles')->simplePaginate('10');
        return view('admin.permissions.view', compact('permissions'));
    }
}
