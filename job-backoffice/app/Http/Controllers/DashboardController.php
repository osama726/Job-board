<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        if (auth()->user()->role == 'admin') {
            $data = $this->adminDashboard();
            return view('dashboard.index', $data);
        } else {
            $data = $this->companyOwnerDashboard();
            return view('dashboard.index', $data);
        }
    }

    // Admin dashboard will show overall analytics and insights for the entire platform
    public function adminDashboard() {

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

        return compact('analytics', 'mostAppliedJobs', 'conversionRates');
    }


    // Company owner dashboard will show analytics and insights related to their company, job vacancies, and applications
    public function companyOwnerDashboard() {

        // Get the company of the logged in user
        $company = auth()->user()->companies;

         // Last days active users by the company (Only job-seeker role)
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')
            ->whereHas('jobApplications', function($query) use ($company) {
                $query->whereIn('jobVacancy_id', $company->jobVacancies->pluck('id'));
            })
            ->count();

        // Total applications for the company's job vacancies (Not deleted)
        $totalJobs = $company->jobVacancies->count();

        // Total applications for the company's job vacancies (Not deleted)
        $totalApplications = JobApplication::whereIn('jobVacancy_id', $company->jobVacancies->pluck('id'))->count();

        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications
        ];

        // Most applied jobs of the company
        $mostAppliedJobs = JobVacancy::withCount('jobApplications')
        ->whereIn('id', $company->jobVacancies->pluck('id'))
        ->orderByDesc('job_applications_count')
        ->limit(5)
        ->get();

        // Conversion Rate of the company's job vacancies
        $conversionRates = JobVacancy::withCount('jobApplications')
        ->whereIn('id', $company->jobVacancies->pluck('id'))
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

        return compact('analytics', 'mostAppliedJobs', 'conversionRates');;
    }
}
