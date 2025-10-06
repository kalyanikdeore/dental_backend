<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_doctors_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->string('experience');
            $table->text('specialization');
            $table->json('achievements')->nullable();
            $table->text('seo_keywords');
            $table->text('description');
            $table->string('image');
            $table->string('alt_text');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('doctor_faqs', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->text('answer');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('why_choose_us_points', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('point');
            $table->string('icon')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('why_choose_us_points');
        Schema::dropIfExists('doctor_faqs');
        Schema::dropIfExists('doctors');
    }
};