<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {

        // Last days active users (Only job-seeker role)
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')->count();

        // Total jobs (Not deleted)
        $totalJobs = JobVacancy::whereNull('deleted_at')->count();

        // Total applications (Not deleted)
        $totalApplications = JobApplication::whereNull('deleted_at')->count();

        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications
        ];

        // Most applied jobs
        $mostAppliedJobs = JobVacancy::withCount('jobApplications')
        ->whereNull('deleted_at')
        ->orderByDesc('job_applications_count')
        ->limit(5)
        ->get();

        // Conversion Rate
        $conversionRates = JobVacancy::withCount('jobApplications')
        ->having('job_applications_count', '>', 0)
        ->orderByDesc('job_applications_count')
        ->limit(5)
        ->get()
        ->Map( function ($job) {
            if($job->view_count > 0)
                $job->conversionRate = round($job->job_applications_count / $job->view_count * 100, 2);
            else
                $job->conversionRate = 0;

            return $job;
        });

        return view('dashboard.index', compact('analytics', 'mostAppliedJobs', 'conversionRates'));
    }
}
