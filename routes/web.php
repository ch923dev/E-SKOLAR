<?php

use App\Mail\TestMail;
use App\Models\ScholarshipOrganization;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/mail', function () {
    User::where('email', 'cdeasis923@gmail.com')->delete();
    User::create([
        'name' => 'Christian De Asis',
        'email' => 'cdeasis923@gmail.com',
        'password' => Hash::make('password'),
        'role_id' => 1
    ]);
    return view('welcome');
});
