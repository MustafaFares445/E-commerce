<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    private mixed $parents;
    public function __construct($resource , $parents = null)
    {
        parent::__construct($resource);
        $this->parents = $parents;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' =>  $this->resource->name,
            'slug' => $this->resource->slug,
            'image' => asset($this->resource->image),
            'parents' => CategoryParentResource::collection($this->parents)
        ];
    }
}
