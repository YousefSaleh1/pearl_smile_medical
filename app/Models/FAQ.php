<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class FAQ extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'question',
        'answer'
    ];

    /**
     * The attributes that are translatable.
     *
     * These fields will have translations for different languages using the Spatie Translatable package.
     *
     * @var array<int, string> List of translatable attributes.
     */
    public $translatable = [
        'question',
        'answer'
    ];

    /**
     * Get the service that owns the FAQ
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
