<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faculty;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::latest()->simplePaginate(10);
        return view('admin.department.index', compact('departments'));
    }

    public function create()
    {
        $faculties = Faculty::all();
        return view('admin.department.create', compact('faculties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments',
            'description' => 'required|string',
            'faculty_id' => 'required'
        ]);

        Department::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'faculty_id' => $request->faculty_id
        ]);

        $notification = [
            'message' => 'Department Created!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.manage.department')->with($notification);
    }

    public function edit($slug){
        $department = Department::where('slug', $slug)->first();
        $faculties = Faculty::all();
        return view('admin.department.edit', compact('department', 'faculties'));
    }

    public function update(Request $request, $slug){
        $request->validate([
            'name' =>'required|string|max:255',
            'description' =>'required|string',
            'faculty_id' =>'required'
        ]);

        $department = Department::where('slug', $slug)->first();
        $department->name = $request->name;
        $department->slug = Str::slug($request->name);
        $department->description = $request->description;
        $department->faculty_id = $request->faculty_id;
        $department->save();

        $notification = [
          'message' => 'Department Updated!',
            'alert-type' =>'success'
        ];

        return redirect()->route('admin.manage.department')->with($notification);
    }


    public function destroy($slug){
        $department = Department::where('slug', $slug)->first();
        $department->delete();
        $notification = [
          'message' => 'Department Deleted!',
            'alert-type' =>'success'
        ];

        return redirect()->route('admin.manage.department')->with($notification);
    }
}
