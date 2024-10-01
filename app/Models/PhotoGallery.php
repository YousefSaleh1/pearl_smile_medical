<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PhotoGallery extends Model
{
    use HasFactory;

    /**
     * Get all of the images for the Galary.
     *
     * This method defines a polymorphic one-to-many relationship between the Galary and Image models.
     * A Galary can have multiple images associated with it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
