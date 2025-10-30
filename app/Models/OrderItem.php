<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // ✅ Fillable attributes
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    /**
     * 🔗 Get the order this item belongs to.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * 🔗 Get the product associated with this order item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
