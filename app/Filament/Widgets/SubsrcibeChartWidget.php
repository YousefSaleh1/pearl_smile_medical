<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Subscriber;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class SubsrcibeChartWidget extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {

        $start = $this->filters['startDate'];  
        $end = $this->filters['endDate'];
        
        $data = Trend::model(Subscriber::class)
        ->between(
            start: $start ? Carbon::parse($start) : now()->subYear(),
            end: $end ? Carbon::parse($end) : now(),
        )
        ->perMonth()
        ->count();
 
    return [
        'datasets' => [
            [
                'label' => 'Subscribers',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
