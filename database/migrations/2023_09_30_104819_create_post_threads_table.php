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
        Schema::create('post_threads', function (Blueprint $table) {
			$table->id();
			$table->timestamps();
			$table->foreignId("post_id")->constrained()->cascadeOnDelete();
			$table->foreignId("user_id")->constrained()->cascadeOnDelete();
			$table->float("x");
			$table->float("y");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_threads');
    }
};
