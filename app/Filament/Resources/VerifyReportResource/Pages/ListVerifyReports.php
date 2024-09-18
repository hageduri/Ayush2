<?php

namespace App\Filament\Resources\VerifyReportResource\Pages;

use App\Filament\Resources\VerifyReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVerifyReports extends ListRecords
{
    protected static string $resource = VerifyReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
