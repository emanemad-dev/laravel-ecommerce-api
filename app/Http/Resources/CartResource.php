<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray($request): array
    {
        $items = $this->whenLoaded('items', function () {
            return $this->items->map(function ($item) {
                $subtotal = $item->quantity * $item->unit_price;

                return [
                    'product_id' => $item->product_id,
                    'title' => $item->product?->getTranslations('title'),
                    'quantity' => $item->quantity,
                    'unit_price' => (float) $item->unit_price,
                    'subtotal' => round($subtotal, 2),
                ];
            });
        });

        return [
            'id' => $this->id,
            'items' => $items,
            'total' => $items->sum('subtotal'),
        ];
    }
}
