<?php

use App\Http\Controllers\CandidateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

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

    // Choices routes
    Route::get('/candidate/choices', [HomeController::class, 'candidatechoices']);
    Route::get('/department/choices', [HomeController::class, 'departmentChoices']);
    Route::get('/joblevel/choices', [HomeController::class, 'jobLevelChoices']);

    // candidate routes
    Route::get('/candidate', [CandidateController::class, 'getCandidate'])->name('candidate.index');
    Route::post('/candidate/store', [CandidateController::class, 'storecandidate'])->name('candidate.store');
    Route::post('/candidate/storepict', [CandidateController::class, 'storecandidatepict'])->name('candidate.storepict');
    Route::get('/candidate/max-employee-id', [CandidateController::class, 'getMaxEmployeeID'])->name('candidate.maxEmployeeID');
    Route::post('/candidate/update-employee-id', [CandidateController::class, 'updatecandidateNIK'])->name('candidate.updateEmployeeID');
    Route::get('/candidate/edit/{id}', [CandidateController::class, 'editcandidate'])->name('candidate.edit');
    Route::post('/candidate/update/{id}', [CandidateController::class, 'updatecandidate'])->name('candidate.update');
    Route::get('/candidate/delete/{id}', [CandidateController::class, 'deletecandidate'])->name('candidate.delete');

    // Define a GET route with dynamic placeholders for route parameters
    // Route::get('{routeName}/{name?}', [HomeController::class, 'pageView'])->name('home.dynamic.view');
});
