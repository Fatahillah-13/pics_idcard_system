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
    Route::get('/', function () {
        // Return a view named 'index' when accessing the root URL
        return view('index');
    });

    // Choices routes
    Route::get('/choices', [HomeController::class, 'candidatechoices']);


    // Define a GET route with dynamic placeholders for route parameters
    Route::get('{routeName}/{name?}', [HomeController::class, 'pageView'])->name('home.dynamic.view');

    // candidate routes
    Route::post('/candidate/store', [CandidateController::class, 'storecandidate'])->name('candidate.store');
    Route::post('/candidate/storepict', [CandidateController::class, 'storecandidatepict'])->name('candidate.storepict');
    Route::get('/candidate/edit/{id}', [CandidateController::class, 'editcandidate'])->name('candidate.edit');
    Route::post('/candidate/update/{id}', [CandidateController::class, 'updatecandidate'])->name('candidate.update');
    Route::get('/candidate/delete/{id}', [CandidateController::class, 'deletecandidate'])->name('candidate.delete');
});
