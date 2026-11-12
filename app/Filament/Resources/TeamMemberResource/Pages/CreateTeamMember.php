<?php

declare(strict_types=1);

namespace App\Filament\Resources\TeamMemberResource\Pages;

use App\Filament\Resources\TeamMemberResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTeamMember extends CreateRecord
{
    protected static string $resource = TeamMemberResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return TeamMemberResource::mergeUploadedFiles($data);
    }
}
