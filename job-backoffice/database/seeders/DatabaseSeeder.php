<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'Admin@admin.com',
            'password' => Hash::make('Admin'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);


        // Load data from JSON files
        $jobData = json_decode(file_get_contents(database_path('data/job_data.json')), true);
        $jobApplications = json_decode(file_get_contents(database_path('data/job_applications.json')), true);

        // Job Categories
        foreach($jobData['jobCategories'] as $category) {
            JobCategory::create([
                'name' => $category,
            ]);
        }

        // Companies and Company Owners
        foreach($jobData['companies'] as $company) {
            // Create a company owner user for each company
            $companyOwner = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('12345678'),
                'role' => 'company-owner',
                'email_verified_at' => now(),
            ]);

            // Create the company with the associated company owner
            Company::create([
                'name' => $company['name'],
                'address' => $company['address'],
                'industry' => $company['industry'],
                'website' => $company['website'],
                'owner_id' => $companyOwner->id,
            ]);
        }

        // Job Vacancies
        foreach($jobData['jobVacancies'] as $jobVacancy) {
            // Find the associated company and category by name
            $company = Company::where('name', $jobVacancy['company'])->firstOrFail();
            $category = JobCategory::where('name', $jobVacancy['category'])->firstOrFail();

            // Create the job vacancy with the associated company and category
            JobVacancy::create([
                'title' => $jobVacancy['title'],
                'description' => $jobVacancy['description'],
                'location' => $jobVacancy['location'],
                'type' => $jobVacancy['type'],
                'salary' => $jobVacancy['salary'],
                'company_id' => $company->id,
                'category_id' => $category->id,
            ]);
        }


        // Job Applications
        foreach($jobApplications['jobApplications'] as $Application) {
            // Create a Randomly select a job vacancy for the application, job seeker user and their resume
            $jobVacancy = JobVacancy::inRandomOrder()->first();
            $jobSeeker = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('12345678'),
                'role' => 'job-seeker',
                'email_verified_at' => now(),
            ]);
            $resume = Resume::create([
                'filename' => $Application['resume']['filename'],
                'fileUrl' => $Application['resume']['fileUri'],
                'contactDetails' => $Application['resume']['contactDetails'],
                'summary' => $Application['resume']['summary'],
                'skills' => $Application['resume']['skills'],
                'experience' => $Application['resume']['experience'],
                'education' => $Application['resume']['education'],

                'user_id' => $jobSeeker->id,
            ]);

            // Create the job application with the associated job vacancy, resume and user
            JobApplication::create([
                'status' => $Application['status'],
                'aiGeneratedScore' => $Application['aiGeneratedScore'],
                'aiGeneratedFeedback' => $Application['aiGeneratedFeedback'],

                'jobVacancy_id' => $jobVacancy->id,
                'resume_id' => $resume->id,
                'user_id' => $jobSeeker->id,
            ]);
        }


    }
}
