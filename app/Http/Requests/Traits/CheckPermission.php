<?php

namespace App\Http\Requests\Traits;

trait CheckPermission
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->checkPermission($this->permission);
    }


    /**
     * @param string $permission
     *
     * @return bool
     */
    public function checkPermission(string $permission): bool
    {
        $user = \Auth::user();

        if ($user->company_id) {
            return \Auth::user()->can("company.{$user->company_id}.$permission");
        }

        return \Auth::user()->can($permission);
    }
}
