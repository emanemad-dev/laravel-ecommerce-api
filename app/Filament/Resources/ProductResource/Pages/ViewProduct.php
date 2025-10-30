<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('title_en')->label('Title (EN)'),
                TextEntry::make('title_ar')->label('Title (AR)'),
                TextEntry::make('description_en')->label('Description (EN)'),
                TextEntry::make('description_ar')->label('Description (AR)'),
                TextEntry::make('price')->label('Price'),
                TextEntry::make('quantity')->label('Quantity'),
                ImageEntry::make('image')
                    ->getStateUsing(fn($record) => $record->getFirstMediaUrl('images'))
                    ->label('Product Image'),
            ]);
    }
}
