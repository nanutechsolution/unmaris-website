<?php

namespace App\Filament\Resources\PopupPromos\Pages;

use App\Filament\Resources\PopupPromos\PopupPromoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPopupPromo extends EditRecord
{
    protected static string $resource = PopupPromoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
