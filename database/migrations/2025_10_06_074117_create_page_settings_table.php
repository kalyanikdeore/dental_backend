<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('page_title');
            $table->text('page_description');
            $table->text('seo_keywords');
            $table->string('cta_title');
            $table->text('cta_description');
            $table->string('phone');
            $table->text('address');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_settings');
    }
};