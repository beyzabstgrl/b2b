<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'status'      => $this->status,
            'total_price' => $this->total_price,
            'user'        => new UserResource($this->whenLoaded('user')),
            'items'       => OrderItemResource::collection($this->whenLoaded('items')),
            'created_at'  => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
