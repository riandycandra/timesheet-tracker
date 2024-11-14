<?php

namespace App\Filament\Resources\TimesheetResource\Pages;

use Filament\Actions;
use App\Filament\Widgets\CalendarWidget;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Exports\TimesheetExporter;
use App\Filament\Resources\TimesheetResource;

class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ExportAction::make()->exporter(TimesheetExporter::class),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }
}
