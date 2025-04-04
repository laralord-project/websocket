<?php

namespace App\Http\Requests\Traits;

trait Paginable
{
    public function paginatorRules(): array
    {
        return [
         'page' => 'min:1',
         'rows' => 'min:1|max:250'
        ];
    }


    public function getAll()
    {

    }
}
