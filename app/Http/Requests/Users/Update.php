<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\ApiRequest;
use App\Models\Profile;
use Auth;
use Illuminate\Validation\Rule;

class Update extends ApiRequest
{
    public string $permission = 'users.update';


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $companyId = $this->input('company_id') ?: Auth::user()->company_id;

        return [
            'email' => [
                'email',
                Rule::unique('users', 'email')
                    ->ignore(Auth::user()),
            ],
            'phone' => 'string|phone|unique:App\Models\User,phone',
            'role_ids' => [
                'bail',
                Rule::exists('roles', 'id')
                    ->where(function ($query) use ($companyId) {
                        if ($companyId) {
                            $query->where('company_id', $companyId);
                        }
                    }),
            ],
            'permission_ids' => [
                Rule::exists('permissions', 'id')
                    ->where(function ($query) use ($companyId) {
                        if ($companyId) {
                            $query->where('company_id', $companyId);
                        }
                    }),
            ],
            'company_id' => [
                Rule::exists('companies', 'id')->where(function ($query) {
                    if (Auth::user()->company_id) {
                        $query->where('id', Auth::user()->company_id);
                    }
                }),
            ],
            'profile.first_name' => 'string|min:2|max:100',
            'profile.last_name' => 'string|min:2|max:100',
            'profile.ui_scheme' => 'in:' . implode(',', Profile::UI_SCHEMES),
            'profile.language_id' => 'exists:App\Models\Language,id',
        ];
    }
}
