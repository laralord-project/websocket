<?php

namespace App\Http\Requests\Applications;

use App\Http\Requests\ApiRequest;
use App\Models\WebsocketApp;
use Illuminate\Validation\Rule;

class Create extends ApiRequest
{
    public string $permission = 'applications.create';

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
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:2',
                Rule::unique(WebsocketApp::class, 'name')
            ]
        ];
    }
}
