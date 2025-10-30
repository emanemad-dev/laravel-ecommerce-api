<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // ✅ Fillable attributes
    protected $fillable = ['user_id', 'total_price'];

    /**
     * 🔗 Get the user who owns this order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 📦 Get all items in this order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
