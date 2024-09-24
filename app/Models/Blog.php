<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Blog extends Model
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
        'tags_en',
        'tags_ar',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tags_en' => 'array',
        'tags_ar' => 'array',
    ];

    /**
     * Get all of the images for the blog post.
     *
     * This method defines a polymorphic one-to-many relationship between the Blog and Image models,
     * where the Blog can have many associated images, and the images can belong to different models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
