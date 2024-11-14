<?php

namespace App\Filament\Widgets;

use App\Models\Timesheet;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Filament\Forms;

class CalendarWidget extends FullCalendarWidget
{

    public Model | string | null $model = Timesheet::class;

    public function getFormSchema(): array
    {
        return [
            Forms\Components\DatePicker::make('date')->native(false)->closeOnDateSelection(),

            Forms\Components\TextInput::make('task'),
            Forms\Components\TextInput::make('description'),
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        return Timesheet::query()
            ->get()
            ->map(
                fn (Timesheet $timesheet) => [
                    'id' => $timesheet->id,
                    'title' => $timesheet->task,
                    'start' => $timesheet->date,
                    'shouldOpenUrlInNewTab' => true
                ]
            )
            ->all();
    }
}
