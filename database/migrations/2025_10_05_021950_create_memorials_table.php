<?php

use App\Models\User;
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
        Schema::create('memorials', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignIdFor(User::class, 'owner_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('pet_name');
            $table->string('headline')->nullable();
            $table->text('summary')->nullable();
            $table->longText('story')->nullable();
            $table->jsonb('theme')->nullable();
            $table->string('status')->default('draft');
            $table->string('visibility')->default('private');
            $table->string('hero_image_path')->nullable();
            $table->timestampTz('published_at')->nullable();
            $table->timestamps();

            $table->index(['owner_id', 'status']);
            $table->index(['visibility', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memorials');
    }
};
