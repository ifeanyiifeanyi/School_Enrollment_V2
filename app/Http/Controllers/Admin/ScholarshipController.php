<?php

namespace App\Http\Controllers\Admin;

use App\Models\Scholarship;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScholarshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scholarships = Scholarship::query()->get();

        // dd($scholarships);
        return view('admin.scholarships.index', compact('scholarships'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:190',
            'description' => 'nullable|string|max:255'
        ]);
        Scholarship::create([
            'slug' => Str::slug($request->name),
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $notification = [
            'message' => "New Scholarship Created!",
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Scholarship $slug)
    {
        dd($slug);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $scholarships = Scholarship::query()->get();
        $scholarship = Scholarship::where('slug', $slug)->first();
        return view('admin.scholarships.index', compact('scholarship', 'scholarships'));
        // return "found";

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:190',
            'description' => 'nullable|string|max:255'
        ]);
        $scholarship = Scholarship::where('slug', $slug)->first();

        $scholarship->update([
            'slug' => Str::slug($request->name),
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $notification = [
            'message' => "Scholarship Updated Successfully!",
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Scholarship $scholarship)
    {
        //
    }
}
