<?php

namespace App\Http\Requests\Traits;

use App\Models\Company;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

trait CompanyField
{
    /**
     * @return array[]
     */
    public function companyRules($required = true)
    {
        return [
            'company_id' => [
                Rule::requiredIf(function () use ($required) {
                    return $required && !Auth::user()->company_id;
                }),
                'bail',
                Rule::exists(Company::class, 'id'),
            ],
        ];
    }

    public function sameCompany(): \Closure
    {
        return function (Builder $query): Builder {
            if (Auth::user()->company_id) {
                $query->where('company_id', Auth::user()->company_id);
            } else {
                $query->where('company_id', $this->input('company_id', null));
            }

            return $query;
        };
    }

    public function sameCompanyAs(Model $model = null): \Closure
    {
        return function (Builder $query) use ($model): Builder {

            $query->where('company_id', $model->company_id ?? null);

            return $query;
        };
    }
}
