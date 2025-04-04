<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\ApiRequest;
use App\Http\Requests\Traits\Paginable;

class Index extends ApiRequest
{
    use Paginable;

    public string $permission = 'users.list';

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
