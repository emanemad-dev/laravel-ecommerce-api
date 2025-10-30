<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['title_en'] = $data['title']['en'] ?? '';
        $data['title_ar'] = $data['title']['ar'] ?? '';
        $data['description_en'] = $data['description']['en'] ?? '';
        $data['description_ar'] = $data['description']['ar'] ?? '';

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
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
