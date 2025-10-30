<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Shop Management';
    protected static ?string $navigationLabel = 'Products';
    protected static ?string $modelLabel = 'Product';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Product Details')
                    ->schema([
                        Forms\Components\TextInput::make('title_en')
                            ->label('Title (EN)')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('title_ar')
                            ->label('Title (AR)')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description_en')
                            ->label('Description (EN)')
                            ->rows(3),

                        Forms\Components\Textarea::make('description_ar')
                            ->label('Description (AR)')
                            ->rows(3),

                        Forms\Components\TextInput::make('price')
                            ->label('Price')
                            ->numeric()
                            ->required(),

                        Forms\Components\TextInput::make('quantity')
                            ->label('Quantity')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->default(0),

                        Forms\Components\SpatieMediaLibraryFileUpload::make('images')
                            ->collection('images')
                            ->label('Product Image')
                            ->image()
                            ->maxSize(2048)
                            ->visibility('public'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable(),

                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->getStateUsing(fn($record) => $record->getFirstMediaUrl('images') ?? null)
                    ->rounded()
                    ->size(50),

                Tables\Columns\TextColumn::make('title_en')
                    ->label('Title (EN)')
                    ->limit(20)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title_ar')
                    ->label('Title (AR)')
                    ->limit(20)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('description_en')
                    ->label('Description (EN)')
                    ->limit(20)
                    ->tooltip(fn($record) => $record->description_en ?? '')
                    ->wrap(),

                Tables\Columns\TextColumn::make('description_ar')
                    ->label('Description (AR)')
                    ->limit(20)
                    ->tooltip(fn($record) => $record->description_ar ?? '')
                    ->wrap(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('usd')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('active')->label('Active Status'),
                Tables\Filters\Filter::make('price_range')
                    ->form([
                        Forms\Components\TextInput::make('min_price')->numeric(),
                        Forms\Components\TextInput::make('max_price')->numeric(),
                    ])
                    ->query(function ($query, array $data) {
                        if ($data['min_price'] ?? false) $query->where('price', '>=', $data['min_price']);
                        if ($data['max_price'] ?? false) $query->where('price', '<=', $data['max_price']);
                    }),
                Tables\Filters\Filter::make('quantity_range')
                    ->form([
                        Forms\Components\TextInput::make('min_quantity')->numeric(),
                        Forms\Components\TextInput::make('max_quantity')->numeric(),
                    ])
                    ->query(function ($query, array $data) {
                        if ($data['min_quantity'] ?? false) $query->where('quantity', '>=', $data['min_quantity']);
                        if ($data['max_quantity'] ?? false) $query->where('quantity', '<=', $data['max_quantity']);
                    }),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->before(fn($record) => $record->clearMediaCollection('images')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(fn($records) => collect($records)->each(fn($record) => $record->clearMediaCollection('images'))),
                ]),
            ])
            ->paginated(true);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'view' => Pages\ViewProduct::route('/{record}'),
        ];
    }
}
