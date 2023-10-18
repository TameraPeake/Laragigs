<?php
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;


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
/*
Common Resource Routes
Index - show all listings
Show - Show single listing
Create - show form to create new listing
Store - Store new Listing
Edit - show form to edit listing
Update - update edited listing
Destroy - delete listing

*/

//all listings
// Route::get('/', 'ListingController@index');
Route::get('/', [ListingController::class, 'index']);

//show create form

Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth'); //middleware checks if you're authorized via http/middleware/authenticate.php

//show Store
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//show Edit
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//show Update
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//show destroy
Route::delete('/listings/{listing}', [ListingController::class, 'delete'])->middleware('auth');

//Manage Listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

//single listings
Route::get('/listings/{listing}', [ListingController::class, 'show']);

//show register/create form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

//create new user
Route::post('/users', [UserController::class, 'store']);

//Log user out
Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');

//Show login form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest'); //middleware allows guests to access this
//http/middleware/authenticate.php checks if the request comes back to true or false. if false, then it redirects to login
//if true then continue to route specified.
//if auth is false, but the middleware recognizes the route as being accessible to guests, then you're allowed to continue to that route. Otherwise, it redirects to login

//Log in user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);



// Route::get('/listings/{listing}', [ListingController::class, 'show']);
// Route::get('/listings/{lisitng}', function (Listing $listing) {

//     return view('listing', [
//         'listing' => $listing
//     ]);

// });
// Route::get('/listings/{id}', [ListingController::class, 'show']);
// Route::get('/hello', function () {
//     return response('<h1>Hello World</h1>', 200)
//         ->header('Content-type', 'text/plain')
//         ->header('foo', 'bar');
// });

// Route::get('/posts/{id}', function ($id) {
//     dd($id);
//     return response('Post '.$id);
// })->where('id', '[0-9]+');

// Route::get('/search', function (Request $request) {
//     return ($request->name . ' ' . $request->city);
// });
