<?php

namespace App\Filament\Resources\PopupPromos;

use App\Filament\Resources\PopupPromos\Pages\CreatePopupPromo;
use App\Filament\Resources\PopupPromos\Pages\EditPopupPromo;
use App\Filament\Resources\PopupPromos\Pages\ListPopupPromos;
use App\Filament\Resources\PopupPromos\Schemas\PopupPromoForm;
use App\Filament\Resources\PopupPromos\Tables\PopupPromosTable;
use App\Models\PopupPromo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PopupPromoResource extends Resource
{
    protected static ?string $model = PopupPromo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;


    public static function form(Schema $schema): Schema
    {
        return PopupPromoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PopupPromosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPopupPromos::route('/'),
            'create' => CreatePopupPromo::route('/create'),
            'edit' => EditPopupPromo::route('/{record}/edit'),
        ];
    }
}
