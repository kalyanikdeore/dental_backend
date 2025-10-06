<?php
// database/migrations/xxxx_xx_xx_create_stats_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->string('label');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stats');
    }
};