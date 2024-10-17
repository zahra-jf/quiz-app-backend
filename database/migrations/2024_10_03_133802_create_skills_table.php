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
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tag');
            $table->integer('duration')->default(10)->comment('in Minutes');
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 - Inactive, 1 - Active');
            $table->tinyInteger('difficulty')->default(0)->comment('0 - easy, 1 - medium, 2 - hard');
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
        Schema::dropIfExists('skills');
    }
};
