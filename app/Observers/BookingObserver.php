<?php

namespace App\Observers;

use App\Models\Booking;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking): void
    {
        Notification::make()
            ->title('New Booking Added')
            ->success()
            ->body('A new booking was made by ' . $booking->name . ' for the service: ' . $booking->service->title_en . '.')
            ->actions([
                Action::make('markAsUnread')
                    ->button()
                    ->markAsUnread(),
                Action::make('markAsUnread')
                    ->button()
                    ->markAsUnread(),
            ])
            ->send();
    }

    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "deleted" event.
     */
    public function deleted(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     */
    public function restored(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     */
    public function forceDeleted(Booking $booking): void
    {
        //
    }
}
