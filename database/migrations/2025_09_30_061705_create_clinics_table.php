<?php
// database/migrations/xxxx_xx_xx_000001_create_clinics_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // deolali-camp-gallery, nashik-road-gallery
            $table->string('name'); // Deolali Camp Clinic Gallery
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinics');
    }
};