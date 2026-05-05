<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobCategoryRequest;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = JobCategory::latest()->paginate(5)->onEachSide(2);
        return view('job-category.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('job-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobCategoryRequest $request)
    {
        JobCategory::create($request->validated());
        return to_route('job-categories.index')->with('success', 'Job category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobCategory $JobCategory)
    {
        return view('job-category.edit', ['category' => $JobCategory ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobCategoryRequest $request, JobCategory $JobCategory)
    {
        $JobCategory->update($request->validated());
        return to_route('job-categories.index')->with('success', 'Job category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobCategory $JobCategory)
    {
        $JobCategory->delete();
        return to_route('job-categories.index')->with('success', 'Job category deleted successfully.');
    }
}
