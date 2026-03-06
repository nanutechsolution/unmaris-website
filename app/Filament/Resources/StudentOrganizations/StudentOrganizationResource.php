<?php

namespace App\Filament\Resources\StudentOrganizations;

use App\Enums\NavigationGroup;
use App\Filament\Resources\StudentOrganizations\Pages\CreateStudentOrganization;
use App\Filament\Resources\StudentOrganizations\Pages\EditStudentOrganization;
use App\Filament\Resources\StudentOrganizations\Pages\ListStudentOrganizations;
use App\Filament\Resources\StudentOrganizations\Schemas\StudentOrganizationForm;
use App\Filament\Resources\StudentOrganizations\Tables\StudentOrganizationsTable;
use App\Models\StudentOrganization;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StudentOrganizationResource extends Resource
{
    protected static ?string $model = StudentOrganization::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Organisasi Mahasiswa';
    protected static ?string $pluralModelLabel = 'Organisasi Mahasiswa';
    protected static ?string $navigationLabel = 'Organisasi Mahasiswa';
    protected static string | \UnitEnum | null $navigationGroup = NavigationGroup::Kemahasiswaan;
    protected static ?int $navigationSort = 1;
   

    public static function form(Schema $schema): Schema
    {
        return StudentOrganizationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentOrganizationsTable::configure($table);
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
            'index' => ListStudentOrganizations::route('/'),
            'create' => CreateStudentOrganization::route('/create'),
            'edit' => EditStudentOrganization::route('/{record}/edit'),
        ];
    }
}
