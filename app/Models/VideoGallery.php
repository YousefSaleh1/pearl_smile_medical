<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class VideoGallery extends Model
{
    use HasFactory;

    /**
     * Get all of the videos for the Galary.
     *
     * This method defines a polymorphic one-to-many relationship between the Galary and Video models.
     * A Galary can have multiple videos associated with it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function videos(): MorphMany
    {
        return $this->morphMany(Video::class, 'videoable');
    }
}
