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
        Schema::create('media_assets', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('memorial_id')->constrained('memorials')->cascadeOnDelete();
            $table->string('collection')->default('gallery');
            $table->string('disk')->default('s3');
            $table->string('path');
            $table->string('thumbnail_path')->nullable();
            $table->string('type')->default('image');
            $table->unsignedInteger('sort_order')->default(0);
            $table->jsonb('meta')->nullable();
            $table->timestamps();

            $table->index(['memorial_id', 'collection']);
            $table->index(['collection', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_assets');
    }
};
