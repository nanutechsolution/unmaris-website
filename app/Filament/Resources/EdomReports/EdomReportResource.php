<?php

namespace App\Filament\Resources\EdomReports;

use App\Enums\NavigationGroup;
use App\Filament\Resources\EdomReports\Pages\CreateEdomReport;
use App\Filament\Resources\EdomReports\Pages\EditEdomReport;
use App\Filament\Resources\EdomReports\Pages\ListEdomReports;
use App\Filament\Resources\EdomReports\Schemas\EdomReportForm;
use App\Filament\Resources\EdomReports\Tables\EdomReportsTable;
use App\Models\EdomReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EdomReportResource extends Resource
{
    protected static ?string $model = EdomReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $modelLabel = 'Laporan EDOM';
    protected static ?string $pluralModelLabel = 'Laporan EDOM';
    protected static ?string $navigationLabel = 'Laporan EDOM';
    protected static string | \UnitEnum | null $navigationGroup = NavigationGroup::Akademik;
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return EdomReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EdomReportsTable::configure($table);
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
            'index' => ListEdomReports::route('/'),
            'create' => CreateEdomReport::route('/create'),
            'edit' => EditEdomReport::route('/{record}/edit'),
        ];
    }
}
