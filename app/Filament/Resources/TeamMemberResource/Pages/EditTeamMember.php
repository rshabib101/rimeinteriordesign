<?php

declare(strict_types=1);

namespace App\Filament\Resources\TeamMemberResource\Pages;

use App\Filament\Resources\TeamMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeamMember extends EditRecord
{
    protected static string $resource = TeamMemberResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return TeamMemberResource::mergeUploadedFiles($data);
    }

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
