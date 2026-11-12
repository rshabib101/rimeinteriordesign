<?php

declare(strict_types=1);

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return ServiceResource::mergeUploadedFiles($data);
    }

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
