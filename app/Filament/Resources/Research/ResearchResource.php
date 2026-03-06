<?php

namespace App\Filament\Resources\Research;

use App\Enums\NavigationGroup;
use App\Filament\Resources\Research\Pages\CreateResearch;
use App\Filament\Resources\Research\Pages\EditResearch;
use App\Filament\Resources\Research\Pages\ListResearch;
use App\Filament\Resources\Research\Schemas\ResearchForm;
use App\Filament\Resources\Research\Tables\ResearchTable;
use App\Models\Research;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ResearchResource extends Resource
{
    protected static ?string $model = Research::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Penelitian';
    protected static ?string $pluralModelLabel = 'Penelitian';
    protected static ?string $navigationLabel = 'Penelitian';
    protected static string | \UnitEnum | null $navigationGroup = NavigationGroup::Akademik;
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return ResearchForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ResearchTable::configure($table);
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
            'index' => ListResearch::route('/'),
            'create' => CreateResearch::route('/create'),
            'edit' => EditResearch::route('/{record}/edit'),
        ];
    }
}
