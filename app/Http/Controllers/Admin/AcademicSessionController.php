<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\AcademicSession;
use App\Http\Controllers\Controller;

class AcademicSessionController extends Controller
{
    public function index()
    {
        $academicSessions = AcademicSession::query()->get();
        return view('admin.academic_sessions.index', compact('academicSessions'));
    }

    public function create()
    {
        return view('admin.academic_sessions.create');
    }

    public function store(Request $request)
    {
        $request->validate(['session' => 'required|string|unique:academic_sessions,session', 'status' => 'required|string']);
        $notification = [
            'message' => 'New Session Created!',
            'alert-type' => 'success'
        ];
        AcademicSession::create($request->all());
        return redirect()->route('admin.academicSession.view')->with($notification);
    }

    public function edit(AcademicSession $academicSession)
    {
        return view('admin.academic_sessions.edit', compact('academicSession'));
    }

    public function update(Request $request, AcademicSession $academicSession)
    {
        $request->validate(['session' => 'required|string|unique:academic_sessions,session,' . $academicSession->id, 'status' => 'required|string']);
        $academicSession->update($request->all());

        $notification = [
            'message' => 'New Session Updated!',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.academicSession.view')->with($notification);

    }

    public function destroy(AcademicSession $academicSession)
    {
        $academicSession->delete();
        $notification = [
            'message' => 'Session Deleted!',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.academicSession.view')->with($notification);
    }
}
