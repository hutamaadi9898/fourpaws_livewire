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
        Schema::create('tributes', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('memorial_id')->constrained('memorials')->cascadeOnDelete();
            $table->string('submitter_name');
            $table->string('submitter_email')->nullable();
            $table->string('relationship')->nullable();
            $table->string('headline')->nullable();
            $table->text('message');
            $table->string('status')->default('pending');
            $table->timestampTz('approved_at')->nullable();
            $table->timestampTz('rejected_at')->nullable();
            $table->timestampTz('published_at')->nullable();
            $table->string('moderated_by')->nullable();
            $table->timestamps();

            $table->index(['memorial_id', 'status']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tributes');
    }
};
