<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'quantity'    => $this->quantity,
            'unit_price'  => $this->unit_price,
            'product'     => [
                'id'    => $this->product->id,
                'name'  => $this->product->name,
                'sku'   => $this->product->sku,
                'price' => $this->product->price,
            ]
        ];
    }
}
