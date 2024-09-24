<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
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
        'email',
        'facebook_link',
        'instegram_link',
        'whatsapp',
        'phone_numbers',
        'address_en',
        'address_ar'
    ];

}
