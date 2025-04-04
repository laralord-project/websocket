<?php

namespace App\Http\Requests\Users;

//use App\Models\Profile;
//use App\Models\Role;
use App\Http\Requests\ApiRequest;
use App\Models\User;
use Auth;
use Illuminate\Validation\Rule;

class Create extends ApiRequest
{
    public string $permission = 'users.create';


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        /** @var User $user */
        $user = Auth::user();
        $companyId = $this->input('company_id') ?: $user->client_id;

        return [
            'first_name' => 'required|string|min:2|max:100',
            'last_name' => 'required|string|min:2|max:100',
            'email' => 'required|email|unique:App\Models\User,email',
            'phone' => 'required|string|phone|unique:App\Models\User,phone',
            'role_ids' => [
                'required',
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
                Rule::requiredIf(function () use ($companyId, $user) {
                    if ($user->company_id) {
                        return false;
                    }

                    $roleIds = $this->input('role_ids');

                    if (is_string($roleIds)) {
                        $roleIds = explode(',', $roleIds);
                    }
                    $roleIds = collect($roleIds);

                    return Role::whereIn('id', $roleIds->toArray())
                        ->whereNotNull('company_id')
                        ->exists();
                }),
                Rule::exists('companies', 'id')->where(function($query) {
                    if (Auth::user()->company_id) {
                      $query->where('id', Auth::user()->company_id);
                    }
                })
            ],
            'schema' => 'in:' . implode(',', Profile::UI_SCHEMES),
            'language_id' => 'exists:App\Models\Language,id',
        ];
    }

    /**
     * Add parameters to be validated
     *
     * @param null $key
     *
     * @return array
     */
    public function all($key = null): array
    {
        $parent = parent::all($key);

        if (isset($parent['phone'])) {
            $parent['phone'] = preg_replace("/[^0-9]/", "", $parent['phone']);
        }

        return $parent;
    }
}
