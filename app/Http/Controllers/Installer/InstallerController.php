<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InstallerController extends Controller
{
    public function index()
    {

        //check if th installation has been done
        if (env('APP_INSTALLED', false)) {
            return redirect('/');
        }

        // check if the application meets the php requirement
        $requiredPHP = '8.1';
        if (version_compare(PHP_VERSION, $requiredPHP, '<')) {
            return view('installer.php_version_error', compact('requiredPHP'));
        }

        // if requirement was met
        return view('installer.index');
    }


    public function store(Request $request){
        if (env('APP_INSTALLED', false)) {
            return redirect('/');
        }
    }
}
