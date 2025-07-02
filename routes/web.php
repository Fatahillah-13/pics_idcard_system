<?php

use App\Http\Controllers\CandidateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginTestController;

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


Auth::routes();

    Route::get('/login-test', function () {
        return view('auth.login');
    });

    Route::get('/logout-test', [LoginTestController::class, 'logout'])->name('logout.auth.test');

    Route::post('/auth/login-test', [LoginTestController::class, 'authenticate'])->name('login.auth.test');


// Define a group of routes with 'auth' middleware applied
Route::middleware(['auth'])->group(function () {
    // Define a GET route for the root URL ('/')
    // Route::get('/', function () {
    //     // Return a view named 'index' when accessing the root URL
    //     return view('index');
    // });

    // Route to All Views
    Route::get('/', function () {
        return view('index');
    });
    Route::get('/candidate/store', [HomeController::class, 'pictNumber'])->name('candidate.store');
    Route::get('/candidate/takephoto', function () {
        return view('pics.TakePict');
    });
    Route::get('/candidate/addNIK', function () {
        return view('pics.PrintIDCard');
    });
    Route::get('/reprint', function () {
        return view('pics.rePrintIdCard');
    });

    // Choices routes
    Route::get('/candidate/choices', [HomeController::class, 'candidatechoices']);
    Route::get('/candidate-no-pict/choices', [HomeController::class, 'candidateNoPictChoices']);
    Route::get('/department/choices', [HomeController::class, 'departmentChoices']);
    Route::get('/joblevel/choices', [HomeController::class, 'jobLevelChoices']);

    // candidate routes
    Route::get('/candidate/get', [CandidateController::class, 'getCandidate'])->name('candidate.get');
    Route::get('/candidate/new', [CandidateController::class, 'getNewCandidateDatatable'])->name('candidate.new');
    Route::get('/candidate', [CandidateController::class, 'getCandidateDatatable'])->name('candidate.index');
    Route::post('/candidate/store', [CandidateController::class, 'storecandidate'])->name('candidate.store');
    Route::get('/candidate/max-employee-id', [CandidateController::class, 'getMaxEmployeeID'])->name('candidate.maxEmployeeID');
    Route::post('/candidate/update-employee-id', [CandidateController::class, 'updatecandidateNIK'])->name('candidate.updateEmployeeID');
    Route::get('/candidate/edit/{id}', [CandidateController::class, 'editcandidate'])->name('candidate.edit');
    Route::post('/candidate/update/{id}', [CandidateController::class, 'updatecandidate'])->name('candidate.update');
    Route::delete('/candidate/delete/{id}', [CandidateController::class, 'deletecandidate'])->name('candidate.delete');
    Route::post('/candidate/print', [CandidateController::class, 'printIDCard'])->name('candidate.printIDCard');
    Route::post('/candidate/import', [CandidateController::class, 'importExcel'])->name('candidate.import');

    // Print ID Card Route
    Route::post('/candidate/print-idcard', [CandidateController::class, 'printIDCard'])->name('candidate.printIDCard');

    // ID Card Template Route
    Route::get('/candidate/idcard', [SettingsController::class, 'showGallery'])->name('idcard.gallery');
    Route::post('/card-template/upload', [SettingsController::class, 'uploadIdCardTemplate'])->name('idcard.upload');
    Route::delete('/card-template/delete/{id}', [SettingsController::class, 'deleteIdCardTemplate'])->name('idcard.delete');

    // Users routes
    Route::get('/users', [SettingsController::class, 'users'])->name('users.index');
    Route::get('/users/get', [SettingsController::class, 'getUsers'])->name('users.get');
    Route::post('/users/store', [SettingsController::class, 'storeUsers'])->name('users.store');
    Route::get('/users/edit/{id}', [SettingsController::class,  'editUsers'])->name('users.edit');
    Route::post('/users/update/{id}', [SettingsController::class, 'updateUsers'])->name('users.update');
    Route::delete('/users/delete/{id}', [SettingsController::class, 'deleteUsers'])->name('users.delete');

    // Define a GET route with dynamic placeholders for route parameters
    // Route::get('{routeName}/{name?}', [HomeController::class, 'pageView'])->name('home.dynamic.view');
});
