<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Subscriber;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class CustomWidget extends BaseWidget
{
    use InteractsWithPageFilters;


    protected function getStats(): array
    {
        
        $start = $this->filters['startDate'];  
        $end = $this->filters['endDate'];
        return [
            Stat::make('Subscribers count',
            
        Subscriber::when($start,
                fn ($query) => $query->whereDate('created_at', '>',$start))
                ->when($end,
                fn ($query) => $query->whereDate('created_at', '<=',$end))
                ->count())
                ->description('subscribers')
                ->descriptionIcon('heroicon-m-user-group',IconPosition::Before)
                ->chart([1,3,5,10,8,40])
                ->color("primary"),
            Stat::make('Booking count', 
                Booking::when($start,
            fn ($query) => $query->whereDate('created_at', '>',$start))
                ->when($end,
                fn ($query) => $query->whereDate('created_at', '<=',$end))
                ->count())
                ->description('Booking')
                ->descriptionIcon('heroicon-m-calendar-days',IconPosition::Before)
                ->chart([1,3,5,10,8,40])
                ->color("primary"),
        ];
    }

    protected function getColumns(): int
    {
        return 2;
    }
}
