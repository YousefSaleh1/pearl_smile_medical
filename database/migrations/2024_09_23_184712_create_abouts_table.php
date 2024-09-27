<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->text('description_en');
            $table->text('description_ar');
            $table->string('email');
            $table->string('facebook_link');
            $table->string('instegram_link');
            $table->string('whatsapp');
            $table->string('phone_numbers');
            $table->string('address_en');
            $table->string('address_ar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
