<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class MedicalTeam extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_en',
        'name_ar',
        'specializations_en',
        'specializations_ar',
        'resume_en',
        'resume_ar',
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
