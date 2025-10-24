<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appointment_treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('treatment_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('deolali_phone');
            $table->string('nashik_phone');
            $table->date('preferred_date');
            $table->time('preferred_time');
         
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointment_treatments');
    }
};