<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Translatable\HasTranslations;

class Image extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'imageable_id',
        'imageable_type',
        'path',
        'alt'
    ];

    /**
     * The attributes that are translatable.
     *
     * These fields will have translations for different languages using the Spatie Translatable package.
     *
     * @var array<int, string> List of translatable attributes.
     */
    public $translatable = [
        'alt'
    ];

    /**
     * Get the parent imageable model (Blog, MedicalTeam, Section, Offer).
     *
     * This method defines the inverse of a polymorphic relationship, meaning
     * that the image can belong to different models such as Blog, Product, etc.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
