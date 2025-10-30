<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'total' => $this->total,
            'created_at' => $this->created_at->toDateTimeString(),
            'items' => $this->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'title' => $item->product->getTranslations('title'),
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'subtotal' => $item->quantity * $item->unit_price,
                ];
            }),
        ];
    }
}
