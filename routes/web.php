<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JourneyController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdminMiddleware;


Route::redirect('/', 'login', 301);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('is_admin')->group(function () {
Route::get('restore/{id}',[JourneyController::class,'restore'])->name('journey.restore');
Route::get('forcedelete/{id}',[JourneyController::class,'force_delete'])->name('journey.force_delete');
Route::get('journey/trash',[JourneyController::class,'trashed'])->name('journey.trash')->withTrashed();
Route::resource('journey', JourneyController::class);
});


require __DIR__.'/auth.php';
