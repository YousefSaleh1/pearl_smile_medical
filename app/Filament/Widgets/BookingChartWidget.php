<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class BookingChartWidget extends ChartWidget
{

    use InteractsWithPageFilters;
    protected static ?string $heading = 'Chart';
    protected int | string | array $columnSpan = 1;
    protected static ?int $sort = 4;



    protected function getData(): array
    {

        $start = $this->filters['startDate'];  
        $end = $this->filters['endDate'];
        
        
        $data = Trend::model(Booking::class)
        ->between(
            start: $start ? Carbon::parse($start) : now()->subYear(),
            end: $end ? Carbon::parse($end) : now(),
        )
        ->perMonth()
        ->count();
 
    return [
        'datasets' => [
            [
                'label' => 'Booking',
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
