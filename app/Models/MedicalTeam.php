<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Translatable\HasTranslations;

class MedicalTeam extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'specializations',
        'experience',
        'languages_spoken',
        'resume',
        'phone_number'
    ];

    /**
     * The attributes that are translatable.
     *
     * These fields will have translations for different languages using the Spatie Translatable package.
     *
     * @var array<int, string> List of translatable attributes.
     */
    public $translatable = [
        'name',
        'specializations',
        'experience',
        'languages_spoken',
        'resume',
    ];

    /**
     * The services that belong to the MedicalTeam
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'medical_team_service');
    }

    /**
     * Get all of the images for the medical team.
     *
     * This method defines a polymorphic one-to-many relationship between the MedicalTeam and Image models.
     * A medical team can have multiple images associated with it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Get all of the videos for the medical team.
     *
     * This method defines a polymorphic one-to-many relationship between the MedicalTeam and Video models.
     * A medical team can have multiple videos associated with it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function videos(): MorphMany
    {
        return $this->morphMany(Video::class, 'videoable');
    }
}
