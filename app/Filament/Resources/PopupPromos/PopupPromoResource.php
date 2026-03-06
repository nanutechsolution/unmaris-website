<?php

namespace App\Filament\Resources\PopupPromos;

use App\Enums\NavigationGroup;
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

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Popup Promo';
    protected static ?string $pluralModelLabel = 'Popup Promos';
    protected static ?string $navigationLabel = 'Popup Promos';

    protected static string | \UnitEnum | null $navigationGroup = NavigationGroup::Konten;
    protected static ?int $navigationSort = 1;
   
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
