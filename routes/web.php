<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Classes\ReservationistClass;
use App\Classes\ToolsClass;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('create_reservation', [ ReservationistClass::class, 'create_reservation' ])
    ->name('create_reservation');

Route::post('/check_room/', [ ReservationistClass::class, 'check_availability'])
    ->name('/check_room/');

Route::get('room_list', [ ToolsClass::class, 'get_room_list' ])
    ->name('room_list');

Route::post('/delete_reservation/{postdata}', [ ReservationistClass::class, 'delete_reservation_data'])
    ->name('/delete_reservation/{postdata}');

Route::get('generate_report', [ ReservationistClass::class, 'generate_report'])
    ->name('generate_report');

require __DIR__.'/auth.php';
