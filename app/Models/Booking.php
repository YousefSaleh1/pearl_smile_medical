<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'name',
        'email',
        'phone_number',
        'message',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($booking) {
            $recipient = User::where('email', 'admin@admin.com')->first();
            Notification::make()
                ->title('New Booking Added')
                ->success()
                ->body('A new booking was made by ' . $booking->name . ' for the service: ' . $booking->service->title_en . '.')
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

    /**
     * Get the service that owns the Booking
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(service::class, 'service_id');
    }
}
