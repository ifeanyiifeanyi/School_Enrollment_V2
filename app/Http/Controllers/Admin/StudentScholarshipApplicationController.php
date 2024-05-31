<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScholarApplication;
use Illuminate\Http\Request;

class StudentScholarshipApplicationController extends Controller
{
    public function index(){
        $applications = ScholarApplication::with('user', 'scholarship')->latest()->simplePaginate('10');
        return view('admin.scholarshipApplication.index', compact('applications'));
    }

    public function show($id){
        $application = ScholarApplication::with('user', 'scholarship', 'answers')->find($id);
        return view('admin.scholarshipApplication.details', compact('application'));
    }
}
