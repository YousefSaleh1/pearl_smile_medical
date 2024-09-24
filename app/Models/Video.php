<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Video extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'videoable_id',
        'videoable_type',
        'path',
        'size',
        'description_en',
        'description_ar',
    ];

    /**
     * Get the parent videoable model (e.g., section, offer, etc.).
     *
     * This method defines the inverse of a polymorphic relationship, meaning
     * that the video can belong to different models such as Section, Offer, etc.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function videoable(): MorphTo
    {
        return $this->morphTo();
    }
}
