<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_ctas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ctas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            
            // Clinic 1
            $table->string('clinic1_name');
            $table->text('clinic1_address');
            $table->string('clinic1_phone1');
            $table->string('clinic1_phone2')->nullable();
            $table->string('clinic1_hours');
            
            // Clinic 2
            $table->string('clinic2_name');
            $table->text('clinic2_address');
            $table->string('clinic2_phone1');
            $table->string('clinic2_phone2')->nullable();
            $table->string('clinic2_hours');
            
            // Styling
            $table->string('background_color')->default('bg-teal-700');
            $table->string('text_color')->default('text-white');
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ctas');
    }
};