<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JourneyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PointsController;



Route::redirect('/', 'login', 301);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::put('/changePassword', [ProfileController::class, 'updatePassword'])->name('profile.changePassword');
});

Route::middleware('auth')->group(function () {

    Route::get('/users', 'App\Http\Controllers\ProfileController@index')->name('profile.index');
    Route::get('/profile/show/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/{user}', [ProfileController::class, 'edit'])->name('profile.edit');

    //manipulating cover and profile image
    Route::post('/profile/upload-image', [ProfileController::class, 'uploadProfileImage'])->name('profile.uploadImage');
    Route::post('/profile/upload-cover', [ProfileController::class, 'uploadCoverImage'])->name('profile.uploadCover');
    Route::delete('/profile/removecoverimage/{id}', [ProfileController::class, 'removeCoverImage']);
    Route::delete('/profile/removeprofileimage/{id}', [ProfileController::class, 'removeProfileImage']);


});

Route::middleware('is_admin')->group(function () {
    Route::delete('/points/{id}', [PointsController::class, 'destroy'])->name('points.destroy');
    Route::get('restore/{id}', [JourneyController::class, 'restore'])->name('journey.restore');
    Route::get('forcedelete/{id}', [JourneyController::class, 'force_delete'])->name('journey.force_delete');
    Route::get('journey/trash', [JourneyController::class, 'trashed'])->name('journey.trash')->withTrashed();
    Route::resource('journey', JourneyController::class);

});
require __DIR__ . '/auth.php';
