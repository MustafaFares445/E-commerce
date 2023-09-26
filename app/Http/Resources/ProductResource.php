<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
           'name' => $this->name,
           'slug' => $this->slug,
           'description' => $this->description,
           'image' => $this->image,
           'price' => $this->price,
           'category' => CategoryResource::make($this->category) ,
           'store' => StoreResource::make($this->store),
       ];
    }
}
