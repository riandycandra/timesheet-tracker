<?php

namespace App\Filament\Exports;

use App\Models\Timesheet;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TimesheetExporter extends Exporter
{
    protected static ?string $model = Timesheet::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('date')->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->locale('id')->isoFormat('D MMMM YYYY')),
            ExportColumn::make('task'),
            ExportColumn::make('description'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your timesheet export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
