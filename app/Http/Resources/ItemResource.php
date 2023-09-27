<?php

namespace App\Http\Resources;

use App\Helpers\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{

    public $resource;
    public float $total;
    //
    public function __construct($resource , $total)
    {
        $this->resource = $resource;
        $this->total = $total;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product' => ProductResource::make($this->product),
            'quantity' => $this->quantity,
            'total' => Currency::format($this->total)
        ];
    }
}
