<?php

namespace App\Filament\Resources\StudyPrograms;

use App\Enums\NavigationGroup;
use App\Filament\Resources\StudyPrograms\Pages\CreateStudyProgram;
use App\Filament\Resources\StudyPrograms\Pages\EditStudyProgram;
use App\Filament\Resources\StudyPrograms\Pages\ListStudyPrograms;
use App\Filament\Resources\StudyPrograms\Schemas\StudyProgramForm;
use App\Filament\Resources\StudyPrograms\Tables\StudyProgramsTable;
use App\Models\StudyProgram;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StudyProgramResource extends Resource
{
    protected static ?string $model = StudyProgram::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $recordTitleAttribute = 'Program Studi';
    protected static ?string $modelLabel = 'Program Studi';
    protected static ?string $pluralModelLabel = 'Program Studi';
    protected static ?string $navigationLabel = 'Program Studi';
    protected static string | \UnitEnum | null $navigationGroup = NavigationGroup::Akademik;
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return StudyProgramForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudyProgramsTable::configure($table);
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
            'index' => ListStudyPrograms::route('/'),
            'create' => CreateStudyProgram::route('/create'),
            'edit' => EditStudyProgram::route('/{record}/edit'),
        ];
    }
}
