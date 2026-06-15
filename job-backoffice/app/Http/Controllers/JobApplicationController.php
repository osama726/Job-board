<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationRequest;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobApplication::latest();
        if(auth()->user()->role == 'company-owner') {
            $query->whereHas('jobVacancy', function ($vacancyQuery) {
                $vacancyQuery->where('company_id', auth()->user()->companies?->id);
            });
        }


        if($request->input('archived') == true) {
            $query->onlyTrashed();
        }

        $jobApplications = $query->paginate(5)->onEachSide(2);

        return view('job-application.index', compact('jobApplications'));
    }

    /**
     * Display the specified resource.
     */
    public function show(JobApplication $jobApplication)
    {
        return view('job-application.show', compact('jobApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobApplication $jobApplication)
    {
        return view('job-application.edit', compact('jobApplication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobApplicationRequest $request, JobApplication $jobApplication)
    {
        $jobApplication->update(['status' => $request->input('status')]);

        // Check the value of toList query parameter to determine where to redirect
        if($request->input('toList') == false){
            return to_route('job-applications.show', $jobApplication->id)->with('success', 'Applicant status updated successfully.');
        }
        return to_route('job-applications.index')->with('success', 'Applicant status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobApplication $jobApplication)
    {
        $jobApplication->delete();
        return to_route('job-applications.index')->with('success', 'Job application deleted successfully.');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(JobApplication $jobApplication)
    {
        $jobApplication->restore();
        return to_route('job-applications.index')->with('success', 'Job application restored successfully.');
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete(JobApplication $jobApplication)
    {
        $jobApplication->forceDelete();
        return to_route('job-applications.index', ['archived' => true])->with('success', 'Job application permanently deleted successfully.');
    }
}
