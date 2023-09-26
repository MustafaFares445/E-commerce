<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
           'logo_image' => $this->logo_image,
           'cover_image' => $this->cover_image,
       ];
    }
}
