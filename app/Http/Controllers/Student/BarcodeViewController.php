<?php

namespace App\Http\Controllers\Student;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BarcodeViewController extends Controller
{
    public function showDetails($nameSlug) {
        try {
            $user = User::with('student', 'applications.department')
                ->where('nameSlug', $nameSlug)
                ->firstOrFail();
    
            return view('student.qrcode.details', compact('user'));
        } catch (ModelNotFoundException $e) {
            return view('errors.user-not-found');
        }
        // dd($user);
    }
}
