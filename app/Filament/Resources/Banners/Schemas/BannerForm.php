<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Banner Information')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Banner')
                            ->maxLength(255),
                            
                        FileUpload::make('image_url')
                            ->label('Gambar Utama')
                            ->image()
                            ->directory('banners')
                            ->columnSpanFull()
                            ->required(),
                            
                        TextInput::make('link_url')
                            ->label('Tautan URL')
                            ->placeholder('https://...')
                            ->url()
                            ->columnSpanFull(),
                    ])->columns(2),

                \Filament\Schemas\Components\Section::make('Settings')
                    ->schema([
                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->required()
                            ->numeric()
                            ->default(0),
                            
                        Toggle::make('is_active')
                            ->label('Aktifkan Banner Ini')
                            ->default(true),
                    ])->columns(2),
            ]);
    }
}
