<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\CheckPermission;
use App\Http\Requests\Traits\WithPreformat;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ApiRequest
 *
 * @author Vitalii Liubimov <vitalii@liubimov.org>
 * @package App\Http\Requests
 */
abstract class ApiRequest extends FormRequest
{
    use CheckPermission, WithPreformat;

    /**
     * @var string
     */
    public string $permission;


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->can($this->permission);
    }
}
