<?php

namespace App\Http\Requests\Applications;

use App\Http\Requests\ApiRequest;
use App\Models\WebsocketApp;
use Auth;
use Illuminate\Validation\Rule;

class Update extends ApiRequest
{
    public string $permission = 'applications.update';

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
            'name' => [
                'min:2',
                Rule::unique(WebsocketApp::class, 'name')->ignore($this->route('application')),
            ],
            'app_key' => [
                'min:32',
                Rule::unique(WebsocketApp::class, 'app_key')->ignore($this->route('application')),
            ],
            'app_secret' => [
                'min:32',
            ],
            'ping_interval' => 'numeric',

        ];
    }
}
