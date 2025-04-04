<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\WithRelationships;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ApiResource
 *
 * @author Vitalii Liubimov <vitalii@liubimov.org>
 * @package App\Http\Resources\Products
 */
class ApiResource extends JsonResource
{
    use WithRelationships;

    /**
     * @var string[]
     */
    public $with = ['status' => 'success'];

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), $this->relationKeys($request));
    }


    public function with($request)
    {
        $this->addRelationsWrapper();

        return parent::with($request);
    }
}
