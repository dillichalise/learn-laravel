<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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


//All Listings
Route::get('/', [ListingController::class, 'getAll']);

//Single Listing
Route::get('/list-detail/{id}', [ListingController::class, 'getOne']);

// Store listing data.
Route::post('/listing', [ListingController::class, 'store'])->middleware('auth');


// Show create page.
Route::get('/listing/create', [ListingController::class, 'create'])->middleware('auth');

// Show Edit Form
Route::get('/listing/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// Update Listing Form
Route::put('/listing/{listing}', [ListingController::class, 'update'])->middleware('auth');

// Delete listing data
Route::delete('/listing/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

// Show Register/Create Form.
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Register new user
Route::post('/user/register', [UserController::class, 'register'])->middleware('guest');

// Show Login Form.
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Login existing user
Route::post('/user/login', [UserController::class, 'loginUser'])->middleware('guest');

// Logout.
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Manage Listing
Route::get('/listing/manage', [ListingController::class, 'manage']);

Route::get('/home', function () {
    return response('<h1>Hello World! </h1>');
});
