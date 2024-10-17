<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('skill_id');
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('answer_id')->nullable();
            $table->integer('order')->default(0);
            $table->string('image')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
