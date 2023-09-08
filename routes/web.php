<?php

use Illuminate\Support\Facades\Route;

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
$subfolder_domain = config('myconfig.subfolder_domain');

Route::get('/check-email', function () {
    return view('vendor.notifications.email');
});

// tanpa subpath
// Route::any($subfolder_domain.'/{all}', function () {
//     return view('welcome');
// })->where('all', '^(?!api).*$');

// subpath
Route::any('{all}', function () {
    return view('welcome');
})->where('all', '^(?!api).*$');

