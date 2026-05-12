<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobVacancyRequest;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobVacancy::latest();

        if($request->input('archived') == true) {
            $query->onlyTrashed();
        }

        $jobVacancies = $query->paginate(5)->onEachSide(2);


        return view('job-vacancy.index', ['jobVacancies' => $jobVacancies]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        $categories = JobCategory::all();
        return view('job-vacancy.create', compact('companies', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobVacancyRequest $request)
    {

        JobVacancy::create($request->validated());

        return to_route('job-vacancies.index')->with('success', 'Job Vacancy created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobVacancy $jobVacancy)
    {
        return view('job-vacancy.show', compact('jobVacancy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobVacancy $jobVacancy)
    {
        $companies = Company::all();
        $categories = JobCategory::all();
        return view('job-vacancy.edit', compact('jobVacancy', 'companies', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobVacancyRequest $request, JobVacancy $jobVacancy)
    {

        $jobVacancy->update($request->validated());

        // Check the value of toList query parameter to determine where to redirect
        if($request->input('toList') == false){
            return to_route('job-vacancies.show', $jobVacancy->id)->with('success', 'Company updated successfully.');
        }

        return to_route('job-vacancies.index')->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobVacancy $jobVacancy)
    {
        $jobVacancy->delete();
        return to_route('job-vacancies.index')->with('success', 'Company deleted successfully.');
    }

    /**
        * Force delete the specified resource from storage.
    */
    public function forceDelete(JobVacancy $jobVacancy)
    {
        $jobVacancy->forceDelete();

        return to_route('job-vacancies.index', ['archived' => true])->with('success', 'Job Vacancy permanently deleted successfully.');
    }

    /**
        * Restore the specified resource from storage.
    */
    public function restore(JobVacancy $jobVacancy)
    {
        $jobVacancy->restore();

        return to_route('job-vacancies.index', ['archived' => true])->with('success', 'Job Vacancy restored successfully.');
    }

}
