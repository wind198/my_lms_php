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
        Schema::table('users', function (Blueprint $table) {
            // Add the generation_id column without constraints initially
            $table->foreignId('generation_id')->nullable(); // Use nullable if you need to handle existing records that might not have a value
        });

        DB::table('users')->update(['generation_id' => 1]);

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('generation_id')->references('id')->on('generations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
