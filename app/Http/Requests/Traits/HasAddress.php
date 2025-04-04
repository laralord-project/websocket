<?php

namespace App\Http\Requests\Traits;

trait HasAddress
{
    public function createAddressRules()
    {
        return [
            'address' => 'required|array',
            'address.country' => 'required|string|nullable',
            'address.city' => 'required|string|nullable',
            'address.address' => 'required|string|nullable',
            'address.zip' => 'string|min:5',
            'address.phone' => 'required|string|min:5',
            'address.email' => 'required|email',
            'address.latitude' => 'numeric',
            'address.longitude' => 'numeric',
            'address.place_id' => 'string',
            'address.zoom' => 'numeric',


        ];
    }

    public function updateAddressRules()
    {
        return [
            'address' => 'array',
            'address.country' => 'string|nullable',
            'address.city' => 'string|nullable',
            'address.address' => 'string|nullable',
            'address.zip' => 'string|min:5',
            'address.phone' => 'string|min:5',
            'address.email' => 'email',
            'address.latitude' => 'numeric',
            'address.longitude' => 'numeric',
            'address.place_id' => 'string',
            'address.zoom' => 'numeric',
        ];
    }
}
