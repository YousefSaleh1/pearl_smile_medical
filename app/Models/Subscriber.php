<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class Subscriber extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email'
    ];


    protected static function boot()
    {
        parent::boot();

        static::created(function ($subscriber) {
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
        });
    }
}
