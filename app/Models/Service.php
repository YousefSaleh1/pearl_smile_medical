<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description'
    ];

    /**
     * The attributes that are translatable.
     *
     * These fields will have translations for different languages using the Spatie Translatable package.
     *
     * @var array<int, string> List of translatable attributes.
     */
    public $translatable = [
        'title',
        'description'
    ];

    /**
     * Get all of the sections for the Service
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class, 'section_id', 'id');
    }

    /**
     * Get all of the faqs for the Service
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function faqs(): HasMany
    {
        return $this->hasMany(FAQ::class, 'section_id', 'id');
    }

    /**
     * Get all of the bookings for the Service
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'section_id', 'id');
    }

    /**
     * Get all of the offers for the Service
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class, 'section_id', 'id');
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
}
