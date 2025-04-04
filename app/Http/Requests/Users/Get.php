<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\ApiRequest;

class Get extends ApiRequest
{
    public string $permission = 'users.read';


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
