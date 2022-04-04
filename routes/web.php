<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\URL;
use App\Models\Artist;
use App\Models\Track;
use App\Models\Genre;
use App\Models\Album;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//How to send a raw test email
Route::get('/mail', function () {
    Mail::raw("What is your favorite framework?", function ($message) {
        $message->to('cheyuany@usc.edu')->subject('Hello From Music app');
    });
});


//Only login users can access the following routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    //All following route goes through prevent blocked user middle ware
    Route::middleware(['prevent-blocked-users'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        /**
         * Invoices
         */
        //[controller::class, 'function name']   ->name('anything really')
        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index');
        Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoice.show');

        Route::view('/blocked', 'blocked')->name('blocked');
    });
});


Route::get("/register", [RegisterController::class, 'index'])->name('registration.index');
Route::post("/register", [RegisterController::class, 'register'])->name('registration.create');

Route::get('/', [AuthController::class, 'loginForm'])->name('login');
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');


/**
 * Albums
 */
Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
//create handles the request to create a new album
Route::get('/albums/new', [AlbumController::class, 'create'])->name('album.create');

//store is the method that does the insert to DB
Route::post('/albums', [AlbumController::class, 'store'])->name('album.store');

Route::get('/eloquent', function () {
    //SELECT * FROM artist;
    //$artists = Artist::all();

//  $tracks = Track::where('unit_price', '>', 0.99)->orderBy('name')->get();

    //INSERT INTO genres...
    //$genre = new Genre();
    //$genre->name = "Hip Hop";
    //at this point, $genre->id is null
    //$genre->save();  //Insert

    //$genre->id is not null
    //$genre->name = 'Alternative';
    //$genre->save();  //Update


    //Genre::find(27)->delete();


//    $metallica = Artist::find(50);
//    return $metallica->albums;


//    $masterOfPuppets = Album::find(152);
//    return $masterOfPuppets->artist;


//    return Genre::find(3)->tracks;

    //Lazy Loading
//    $tracks = Track::take(20)->orderBy('name')->get();

    //Eager Loading
    $tracks = Track::with(['genre'])
        ->take(20)
        ->orderBy('name')
        ->get();

    return view('eloquent', [
        'tracks' => $tracks
    ]);
});

//For deploy on Heroku
if (env('APP_ENV') !== 'local') {
    URL::forceScheme('https');
}
