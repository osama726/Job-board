<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

    // Job Categories routes
    Route::resource('/job-categories', JobCategoryController::class)
    ->except('show');
    Route::put('/job-categories/{JobCategory}/restore', [JobCategoryController::class, 'restore'])
    ->name('job-categories.restore')
    ->withTrashed();
    Route::delete('/job-categories/{JobCategory}/force-delete', [JobCategoryController::class, 'forceDelete'])
    ->name('job-categories.force-delete')
    ->withTrashed();

    // Job Company routes
    Route::resource('/companies', CompanyController::class);
    Route::put('/companies/{company}/restore', [CompanyController::class, 'restore'])
    ->name('companies.restore')
    ->withTrashed();
    Route::delete('/companies/{company}/force-delete', [CompanyController::class, 'forceDelete'])
    ->name('companies.force-delete')
    ->withTrashed();

    Route::resource('/job-applications', JobApplicationController::class);


    Route::resource('/job-vacancies', JobVacancyController::class);
    Route::resource('/users', UserController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

