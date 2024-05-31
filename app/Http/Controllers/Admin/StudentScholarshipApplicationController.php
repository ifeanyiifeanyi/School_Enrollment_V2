<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScholarApplication;
use Illuminate\Http\Request;

class StudentScholarshipApplicationController extends Controller
{
    public function index(){
        $applications = ScholarApplication::with('user', 'scholarship')->latest()->simplePaginate('100');
        return view('admin.scholarshipApplication.index', compact('applications'));
    }

    public function show($id){
        $application = ScholarApplication::with('user', 'scholarship', 'answers')->find($id);
        if (!$application) {
            return redirect()->back();
        }
        return view('admin.scholarshipApplication.details', compact('application'));
    }
}
