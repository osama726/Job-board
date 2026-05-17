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
    Route::put('/job-categories/{job_category}/restore', [JobCategoryController::class, 'restore'])
    ->name('job-categories.restore')
    ->withTrashed();
    Route::delete('/job-categories/{job_category}/force-delete', [JobCategoryController::class, 'forceDelete'])
    ->name('job-categories.force-delete')
    ->withTrashed();

    // Job Companies routes
    Route::resource('/companies', CompanyController::class);
    Route::put('/companies/{company}/restore', [CompanyController::class, 'restore'])
    ->name('companies.restore')
    ->withTrashed();
    Route::delete('/companies/{company}/force-delete', [CompanyController::class, 'forceDelete'])
    ->name('companies.force-delete')
    ->withTrashed();

    // Job jobVacancies routes
    Route::resource('/job-vacancies', JobVacancyController::class);
    Route::put('/job-vacancies/{job_vacancy}/restoore', [JobVacancyController::class, 'restore'])
    ->name('job-vacancies.restore')
    ->withTrashed();
    Route::delete('/job-vacancies/{job_vacancy}/force-delete', [JobVacancyController::class, 'forceDelete'])
    ->name('job-vacancies.force-delete')
    ->withTrashed();

    // Job jobApplications routes
    Route::resource('/job-applications', JobApplicationController::class);
    Route::put('/job-applications/{job_application}/restore', [JobApplicationController::class, 'restore'])
    ->name('job-applications.restore')
    ->withTrashed();
    Route::delete('/job-applications/{job_application}/force-delete', [JobApplicationController::class, 'forceDelete'])
    ->name('job-applications.force-delete')
    ->withTrashed();

    // Job Users routes
    Route::resource('/users', UserController::class);
    Route::put('/users/{user}/restore', [UserController::class, 'restore'])
    ->name('users.restore')
    ->withTrashed();
    Route::delete('/users/{user}/force-delete', [UserController::class, 'forceDelete'])
    ->name('users.force-delete')
    ->withTrashed();

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

