<?php

namespace App\Observers;

use App\Models\Subscriber;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class SubscriberObserver
{
    /**
     * Handle the Subscriber "created" event.
     */
    public function created(Subscriber $subscriber): void
    {
        $recipient = User::where('email', 'admin@admin.com')->first();
        Notification::make()
            ->title('New Subscriber Added')
            ->success()
            ->body('A new subscriber has joined with the email: ' . $subscriber->email . '.')
            ->actions([
                Action::make('view')
                    ->button()
                    ->markAsRead(),
                Action::make('markAsUnread')
                    ->button()
                    ->markAsUnread(),
            ])
            ->sendToDatabase($recipient);
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
