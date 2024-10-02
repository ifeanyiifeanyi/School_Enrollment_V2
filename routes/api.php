<?php

use App\Http\Controllers\API\V1\SendStudentDetailsController;
use App\Http\Controllers\API\V2\SendStudentDetailsController as V2Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::prefix('v1')->group(function () {
    Route::get('/students', [SendStudentDetailsController::class, 'accessStudents']);
    Route::get('/search-students/{search}', [SendStudentDetailsController::class, 'searchStudents']);
});

// Route::prefix('v2')->group(function(){
//     // api/access-students?page=1
//     Route::get('/students', [V2Controller::class, 'accessStudents']);

//     // /api/search-students/John?page=1
//     Route::get('/search-students/{search}', [V2Controller::class,'searchStudents']);
// });
