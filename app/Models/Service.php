<?php

namespace App\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
    ];

    /**
     * Get all of the sections for the Service
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class, 'service_id', 'id');
    }

    /**
     * Get all of the faqs for the Service
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function faqs(): HasMany
    {
        return $this->hasMany(FAQ::class, 'service_id', 'id');
    }

    /**
     * Get all of the bookings for the Service
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'service_id', 'id');
    }

    /**
     * Get all of the offers for the Service
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class, 'service_id', 'id');
    }

    /**
     * The medical_teams that belong to the Service
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function medical_teams(): BelongsToMany
    {
        return $this->belongsToMany(MedicalTeam::class, 'medical_team_service');
    }


       /**
     * Get all of the images for the service.
     *
     * This method defines a polymorphic one-to-many relationship between the service and Image models,
     * where the service can have many associated images, and the images can belong to different models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function service_images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
