<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure the 'products' folder exists in public storage
        Storage::disk('public')->makeDirectory('products');

        // Number of different images to use
        $numImages = 1000; // Only 1000 unique images to save space

        // Generate 10,000 products using the factory
        Product::factory()->count(10000)->create()->each(function ($product, $index) use ($numImages) {

            // Select a random image ID from Picsum (repeats after 1000)
            $imageId = ($index % $numImages) + 1;
            $imageUrl = "https://picsum.photos/id/$imageId/600/400";

            // Temporary path to store the image
            $tempPath = storage_path('app/public/products/' . uniqid() . '.jpg');

            // Download and save the image temporarily
            file_put_contents($tempPath, file_get_contents($imageUrl));

            // Attach the image to the product using Spatie Media Library
            $product->addMedia($tempPath)
                    ->preservingOriginal()
                    ->toMediaCollection('images');

            // Delete the temporary image file
            unlink($tempPath);
        });
    }
}
