<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // List of industries for the dropdown in the create and edit forms
    public $industries = [
        'Technology',
        'Finance',
        'Healthcare',
        'Education',
        'Retail',
        'Manufacturing',
        'Transportation',
        'Energy',
        'Entertainment',
        'Hospitality',
    ];

    public function index(Request $request)
    {
        $query = Company::latest();

        if($request->input('archived') == true) {
            $query->onlyTrashed();
        }

        $companies = $query->paginate(5)->onEachSide(2);


        return view('company.index', ['companies' => $companies]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('company.create', ['industries' => $this->industries]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRequest $request)
    {
        $validated = $request->validated();
        $owner = User::create([
            'name' => $validated['owner_name'],
            'email' => $validated['owner_email'],
            'password' => Hash::make($validated['owner_password']),
            'role' => 'company-owner'
        ]);
        if(!$owner) {
            return back()->with('error', 'Failed to create company owner. Please try again.');
        }

        Company::create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'industry' => $validated['industry'],
            'website' => $validated['website'],
            'owner_id' => $owner->id
        ]);
        return to_route('companies.index')->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $Company)
    {
        return view('company.show', ['company' => $Company]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $Company)
    {
        return view('company.edit', ['company' => $Company, 'industries' => $this->industries]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, Company $Company)
    {
        $validated = $request->validated();

        $Company->update($validated);

        $ownerData = [
            'name' => $validated['owner_name'],
        ];

        // Only update the password if a new one is provided
        if($validated['owner_password']) {
            $ownerData['password'] = Hash::make($validated['owner_password']);
        } else {
            unset($validated['owner_password']);
        }

        $Company->owner->update($ownerData);

        // Check the value of toList query parameter to determine where to redirect
        if($request->input('toList') == false){
            return to_route('companies.show', $Company->id)->with('success', 'Company updated successfully.');
        }

        return to_route('companies.index')->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $Company)
    {
        $Company->delete();
        return to_route('companies.index')->with('success', 'Company deleted successfully.');
    }

    /**
        * Force delete the specified resource from storage.
    */
    public function forceDelete(Company $Company)
    {
        $Company->forceDelete();
        return to_route('companies.index', ['archived' => true])->with('success', 'Company Destroyed successfully.');
    }

    /**
        * Restore the specified resource from storage.
    */
    public function restore(Company $Company)
    {
        $Company->restore();
        return to_route('companies.index', ['archived' => true])->with('success', 'Company restored successfully.');
    }
}
