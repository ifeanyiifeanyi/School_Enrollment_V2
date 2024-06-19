<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class ExamNotificationController extends Controller
{
    public function index(){
        $departments = Department::query()->get();
        // dd($departments);
        return view('admin.examNotification.index', compact('departments'));
    }
}
