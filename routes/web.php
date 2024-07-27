<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Mail\SampleMail;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [UserController::class, 'getDetails'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Another way to route view
Route::view('/page1', 'page1')->name('page');
Route::view('/page2', 'page2');
Route::view('/page3', '/folder1/page3');

Route::post('/apply', [ApplicantController::class, 'createApplicant']);
Route::get('/applicants', [ApplicantController::class, 'getApplicants']);
Route::post('/updateApplicant/{applicant_id}', [ApplicantController::class, 'updateApplicant']);
Route::post('/deleteApplicant/{applicant_id}', [ApplicantController::class, 'deleteApplicant']);



Route::get('/displaytable_admin', [ApplicantController::class, 'displaytable_admin']);
Route::post('/update_jobstatus/{job_id}', [ApplicantController::class, 'update_jobstatus']);
Route::get('/posted_jobs', [ApplicantController::class, 'display_posted_jobs']);
Route::post('/search_job', [ApplicantController::class, 'search_job'])->name('searchJob');

Route::get('/sample_login', [LoginController::class, 'display_sample_login']);
// Route::post('/login_post', [LoginController::class, 'login_post'])->name('sample_login_post')->middleware('throttle:login');
Route::post('/login_post', [LoginController::class, 'login_post'])->name('sample_login_post');



require __DIR__.'/auth.php';


Route::get('/testroute', function() {
    $applicant = "John";

    // The email sending is done using the to method on the Mail facade
    Mail::to('testreceiver@gmail.com')->send(new SampleMail($applicant));
});