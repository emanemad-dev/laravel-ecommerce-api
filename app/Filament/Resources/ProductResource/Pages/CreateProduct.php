<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->prepareTranslations($data);
    }

    private function prepareTranslations(array $data): array
    {
        $data['title'] = [
            'en' => $data['title_en'] ?? '',
            'ar' => $data['title_ar'] ?? '',
        ];

        $data['description'] = [
            'en' => $data['description_en'] ?? '',
            'ar' => $data['description_ar'] ?? '',
        ];

        return $data;
    }
}
