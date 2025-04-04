<?php

namespace App\Http\Requests\Applications;

use App\Http\Requests\ApiRequest;
use App\Http\Requests\Traits\Paginable;

class Index extends ApiRequest
{
    use Paginable;

    public string $permission = 'applications.list';


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
        return $this->paginatorRules();
    }
}
