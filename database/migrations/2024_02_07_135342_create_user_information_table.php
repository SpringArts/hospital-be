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
        Schema::create('user_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('experience')->nullable();
            $table->string('license')->nullable();
            $table->string('age');
            $table->enum('status',['avaliable', 'busy','away']);
            $table->string('specialize')->nullable();
            $table->enum('gender',['male','female','other']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_information');
    }
};
