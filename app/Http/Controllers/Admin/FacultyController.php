<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faculty;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = Faculty::latest()->simplePaginate('10');
        // dd($faculties);

        return view('admin.faculty.index', compact('faculties'));
    }

    public function create()
    {
        return view('admin.faculty.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:faculties',
            'description' => 'nullable|string'
        ]);

        Faculty::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description
        ]);
        $notification = [
            'message' => 'Faculty Created!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.manage.faculty')->with($notification);
    }

    public function edit($slug){
        $faculty = Faculty::where('slug', $slug)->first();
        return view('admin.faculty.edit', compact('faculty'));
    }

    public function update(Request $request, $slug){
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);
        $faculty = Faculty::where('slug', $slug)->first();
        $faculty->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description
        ]);
        $notification = [
            'message' => 'Faculty Details Updated!',
              'alert-type' => 'success'
          ];
  
          return redirect()->route('admin.manage.faculty')->with($notification);
    }

    public function show($slug){
        $faculty = Faculty::where('slug', $slug)->first();
        return view('admin.faculty.show', compact('faculty'));
    }



    public function destroy($slug){
        $faculty = Faculty::where('slug', $slug)->first();
        $faculty->delete();

        $notification = [
          'message' => 'Faculty Deleted!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.manage.faculty')->with($notification);
    }
}
