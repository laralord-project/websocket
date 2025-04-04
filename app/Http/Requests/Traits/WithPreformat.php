<?php

namespace App\Http\Requests\Traits;

use Str;

trait WithPreformat
{
    protected function prepareForValidation(): void
    {
        $with = $this->input('with', []);
        if (is_string($with)) {
            $with = explode(',', $with);
        }

        if (is_array($with)) {
            $with = collect($with)
                ->map(function ($value) {
                    return Str::camel($value);
                })
                ->toArray();
        }

        $this->merge(['with' => $with]);
    }
}
