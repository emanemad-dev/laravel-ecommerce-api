<?php

namespace App\Models;

use App\Models\CartItem;
use App\Models\OrderItem;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    // ✅ Define which attributes are mass assignable
    protected $fillable = ['title', 'description', 'price', 'quantity'];

    // ✅ Define translatable attributes
    public $translatable = ['title', 'description'];

    /**
     * 🔹 Register a media collection for product images
     */
    public function registerMediaCollections(): void
    {
        // Only allow a single image per product
        $this->addMediaCollection('images')->singleFile();
    }

    /**
     * 🔹 Get the URL of the first product image
     */
    public function imageUrl()
    {
        return $this->getFirstMediaUrl('images');
    }

    /**
     * 🔹 Accessor for English title
     */
    public function getTitleEnAttribute()
    {
        return $this->getTranslation('title', 'en');
    }

    /**
     * 🔹 Accessor for Arabic title
     */
    public function getTitleArAttribute()
    {
        return $this->getTranslation('title', 'ar');
    }

    /**
     * 🔹 Accessor for English description
     */
    public function getDescriptionEnAttribute()
    {
        return $this->getTranslation('description', 'en');
    }

    /**
     * 🔹 Accessor for Arabic description
     */
    public function getDescriptionArAttribute()
    {
        return $this->getTranslation('description', 'ar');
    }

    /**
     * 🔹 Define relationship: a product can have many cart items
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * 🔹 Define relationship: a product can have many order items
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * 🔹 Booted method to handle cascading deletes and media cleanup
     */
    protected static function booted()
    {
        static::deleting(function ($product) {
            try {
                // ➡️ Delete related cart items if they exist
                if ($product->cartItems()->exists()) {
                    $product->cartItems()->delete();
                }

                // ➡️ Delete related order items if they exist
                if ($product->orderItems()->exists()) {
                    $product->orderItems()->delete();
                }

                // ➡️ Remove associated media (product images)
                if ($product->hasMedia('images')) {
                    $product->clearMediaCollection('images');
                }
            } catch (\Throwable $e) {
                // ⚠️ Log any deletion errors instead of breaking the request
                \Log::error('Error deleting product: ' . $e->getMessage());
            }
        });
    }
}
