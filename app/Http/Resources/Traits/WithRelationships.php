<?php

namespace App\Http\Resources\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Str;

/**
 * Trait WithRelationships
 *
 * @author Vitalii Liubimov <vitalii@liubimov.org>
 * @package App\Http\Resources\Traits
 */
trait WithRelationships
{
    protected string $relationsWrapper = 'relations';

    public Collection $relations;

    public Collection $relatedKeys;


    public function addRelationsWrapper()
    {
        if (!isset($this->relations)) {
            $this->buildRelations();
        }

        $relations = $this->relations->mapWithKeys(function (Collection $relations, $key) {
            return [$key => $relations->values()->unique()->toArray()];
        });

        if ($relations->isNotEmpty()) {
            $this->with = array_merge_recursive(
                $this->with,
                [$this->relationsWrapper => $relations->toArray()]
            );
        }
    }


    /**
     * Parse and add relationships to response
     *
     * @param $resource
     *
     * @return void
     */
    public function buildRelations($resource = null)
    {
        if (!isset($this->relations)) {
            $this->relations = collect();
        }

        if (!($this->resource instanceof Model)) {
            return;
        }

        if (!$resource) {
            $resource = $this;
        }

        $relations = collect($resource->resource->getRelations());

        $relations->each(function ($relation, $key) {
            if ($key === 'pivot') {
                return;
            }

            $this->attachRelationship($key, $relation);
        });
    }


    /**
     * Method generate the relationships keys
     *
     * @param $request
     *
     * @return array
     */
    public function relationKeys($request): array
    {
        if (!isset($this->relations)) {
            $this->relations = collect();
        }

        if (!($this->resource instanceof Model)) {
            return [];
        }

        $relations = $this->resource->getRelations();

        $map = collect($relations)->mapWithKeys(function ($relations, $key) use (&$request) {
            $this->attachRelationship($key, $relations);
            $relationsKeys = [];

            if (Str::singular($key) === $key) {
                if ($relations && $relations->pivot) {
                    $relationsKeys = [Str::snake($key) . '_pivot' => $relations->pivot];
                } else {
                    $relationsKeys = [Str::snake($key) . '_id' => $relations->id ?? null];
                }
            } elseif (Str::plural(Str::singular($key)) === $key) {
                if (($relations[0]->pivot ?? false) && count($relations[0]->pivot->toArray()) > 2
                    && !$this->shouldSkipPivot($key))
                {
                    $mappedPivot = $relations->mapWithKeys(function ($model) {
                        return ["{$model->id}" => $model->pivot->toArray()];
                    });

                    $relationsKeys = [Str::snake(Str::singular($key)) . '_ids' => $mappedPivot->toArray()];
                } else {
                    $modelIds = $relations->pluck('id');
                    $relationsKeys = [Str::snake(Str::singular($key)) . '_ids' => $modelIds->toArray()];
                }
            };

            return $relationsKeys;
        });

        return $map->toArray();
    }


    /**
     * @param $key
     * @param $value
     *
     * @return Collection
     */
    public function attachRelationship($key, $value): Collection
    {
        if (!isset($this->relations)) {
            $this->relations = collect();
        }

        // workaround for issue pluralize the word children,
        $key = Str::snake(Str::plural(Str::singular($key)));

        if (!$this->relations->has($key)) {
            $this->relations[$key] = collect();
        }

        if (!$value) {
            return $this->relations[$key];
        }

        if ($value instanceof Model) {
            $resource = self::make($value);
            $this->relations[$key][$value->id] = $resource->toArray(null);
            $this->buildRelations($resource);
        } elseif ($value instanceof Collection) {
            $value->map(function ($model) use ($key) {
                $this->attachRelationship($key, $model);
            });
        }

        return $this->relations[$key];
    }


    public function shouldSkipPivot(string $relation): bool
    {
        return  $this->resource && method_exists($this->resource, 'shouldSkipPivot')
            && $this->resource->shouldSkipPivot($relation);
    }
}
