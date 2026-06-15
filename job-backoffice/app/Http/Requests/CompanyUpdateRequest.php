<?php

namespace App\Http\Requests;

use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {


        if (auth()->user()->role == 'admin') {
            $companyModel = $this->route('company');
        } else {
            $companyModel = Company::where('owner_id', auth()->id())->first();
        }

        $companyId = $companyModel ? $companyModel->id : 'NULL';
        $ownerId = ($companyModel && $companyModel->owner) ? $companyModel->owner->id : 'NULL';

        return [
            'name' => 'required|string|max:255|unique:companies,name,' . $companyId,
            'address' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|string|url|max:255',

            // Company Owner
            'owner_name' => 'required|string|max:255|unique:users,name,' . $ownerId,
            'owner_password' => 'nullable|string|min:8',
        ];
    }
}
