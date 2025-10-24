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
Schema::create('welcome_sections', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description');
    $table->json('highlights'); 
    $table->string('cta_text')->nullable();
    $table->string('cta_link')->nullable();
    $table->string('image_1')->nullable();
    $table->string('image_2')->nullable();
    $table->string('image_3')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('welcome_sections');
    }
};
