<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class About extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description_en',
        'description_ar',
        'email',
        'facebook_link',
        'instegram_link',
        'tiktok_link',
        'phone_number',
        'mobile_numbers',
        'whatsapp',
        'address_en',
        'address_ar'
    ];

    protected $casts = [
        'mobile_numbers' => 'array',
    ];

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
