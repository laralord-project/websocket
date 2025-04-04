<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\WithRelationships;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use JsonSerializable;

/**
 * Class ApiCollection
 *
 * @author Vitalii Liubimov <vitalii@liubimov.org>
 * @package App\Http\Resources
 */
class ApiCollection extends ResourceCollection
{
    use WithRelationships;

    /**
     * @var string[]
     */
    public $with = ['status' => 'success'];


    /**
     * @param $request
     *
     * @return array|JsonSerializable|Arrayable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        $this->relations = collect();
        $items = parent::toArray($request);
        $this->collection->each(function (ApiResource $resource) {
            $resource->relations->each(function (Collection $relations, $key) {
                $this->relations[$key] = $this->relations->has($key)
                    ? $this->relations[$key]->union($relations)
                    : collect($relations);
            });
        });

        return $items;
    }


    /**
     * @param Request $request
     *
     * @return array
     */
    public function with($request)
    {
        $this->addRelationsWrapper();

        return $this->with;
    }
}
