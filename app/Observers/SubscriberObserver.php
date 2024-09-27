<?php

namespace App\Observers;

use App\Models\Subscriber;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class SubscriberObserver
{
    /**
     * Handle the Subscriber "created" event.
     */
    public function created(Subscriber $subscriber): void
    {
        Notification::make()
        ->title('New Subscriber Added')
        ->success()
        ->body('A new subscriber has joined with the email: ' . $subscriber->email . '.')
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
     * Handle the Subscriber "updated" event.
     */
    public function updated(Subscriber $subscriber): void
    {
        //
    }

    /**
     * Handle the Subscriber "deleted" event.
     */
    public function deleted(Subscriber $subscriber): void
    {
        //
    }

    /**
     * Handle the Subscriber "restored" event.
     */
    public function restored(Subscriber $subscriber): void
    {
        //
    }

    /**
     * Handle the Subscriber "force deleted" event.
     */
    public function forceDeleted(Subscriber $subscriber): void
    {
        //
    }
}
