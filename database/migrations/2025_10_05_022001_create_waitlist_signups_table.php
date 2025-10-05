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
        Schema::create('waitlist_signups', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->string('email');
            $table->string('name')->nullable();
            $table->string('source')->nullable();
            $table->jsonb('meta')->nullable();
            $table->timestampTz('confirmed_at')->nullable();
            $table->timestamps();

            $table->unique('email');
            $table->index('source');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waitlist_signups');
    }
};
