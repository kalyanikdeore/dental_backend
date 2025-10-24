<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('treatment_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('treatment_id')->constrained()->onDelete('cascade');
            $table->string('h2');
            $table->text('content')->nullable();
            $table->string('list_title')->nullable();
            $table->json('list_items')->nullable();
            $table->json('subsections')->nullable();
            $table->json('ordered_list')->nullable();   
            $table->text('note')->nullable();
            $table->string('image')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('treatment_sections');
    }
};