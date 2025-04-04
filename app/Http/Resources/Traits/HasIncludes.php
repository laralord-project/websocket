<?php

namespace App\Http\Resources\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

/**
 *
 */
trait HasIncludes
{
    /** @var array */
    public array $availableIncludes = [];

    /**
     * @var array
     */
    public array $defaultIncludes = [];

    /**
     * @var array
     */
    public array $includes = [];

    /**
     * @var array
     */
    public array $relations = [];

    /**
     * @var array
     */
    public array $meta = [];


    /**
     * @param $includes
     *
     * @return \App\Http\Resources\ApiCollection|\App\Http\Resources\ApiResource|HasIncludes
     */
    public function withIncludes($includes): self
    {
        if (is_string($includes)) {
            $includes = collect(explode(',', $includes));
        } else {
            $includes = collect($includes);
        }

        $includes = $includes->merge($this->defaultIncludes);
        $availableIncludes = collect($this->getAvailableIncludes());

        $this->includes = $includes->filter(function ($include) use ($availableIncludes) {
            return $availableIncludes->contains($this->parseInclude($include));
        })->all();

        return $this;
    }


    /**
     * Return include could be specified with nested includes - for example: roles.permissions
     *
     * @param $include
     *
     * @return string
     */
    public function parseInclude($include): string
    {
        // taking first part of include
        return explode('.', $include)[0];
    }


    public function getNestedIncludes($include): array
    {
        $includesParts = explode('.', $include);
        array_shift($includesParts);

        return $includesParts;
    }



    public function findInclude(string $include, array $includes): string
    {
        $include = $this->parseInclude($include);
        $includes = collect($includes);

        return $includes->filter(function (string $includeItem) use ($include) {
            return $this->parseInclude($includeItem) == $include;
        })->first() ?: '';
    }


    /**
     * @return array
     */
    public function getAvailableIncludes()
    {
        return $this->availableIncludes;
    }



}
