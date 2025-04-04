<?php

namespace App\Http\Requests\Applications;

use App\Http\Requests\ApiRequest;

class Get extends ApiRequest
{
    public string $permission = 'applications.read';

    public function authorize()
    {
        //  Authentication implemented on top level
        return true;
    }

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
