<?php

namespace App\Filament\Resources\News\Schemas;

use App\Models\News;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;

use Illuminate\Support\Str;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->label('Kategori Berita'),
                TextInput::make('title')
                    ->validationMessages([
                        'required' => 'Judul tidak boleh kosong.',
                    ])
                    ->maxLength(255)
                    ->label('Judul Berita')
                    ->live(onBlur: true)
                    ->afterStateUpdated(
                        fn(string $operation, ?string $state, Set $set) =>
                        $operation === 'create' && filled($state)
                            ? $set('slug', Str::slug($state))
                            : null
                    ),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(News::class, 'slug', ignoreRecord: true),

                Textarea::make('excerpt')
                    ->required()
                    ->columnSpanFull()
                    ->label('Ringkasan Singkat (Excerpt)'),

                RichEditor::make('content')
                    ->required()
                    ->columnSpanFull()
                    ->fileAttachmentsDirectory('news/attachments')
                    ->label('Konten Berita'),
                FileUpload::make('featured_image')
                    ->image()
                    ->disk('public')
                    ->directory('news/images')
                    ->visibility('public')
                    ->imagePreviewHeight('250')
                    ->openable()
                    ->downloadable()
                    ->label('Gambar Utama')
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->required()
                    ->default(true)
                    ->label('Publikasikan?'),
                DateTimePicker::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->default(now()),
            ]);
    }
}
