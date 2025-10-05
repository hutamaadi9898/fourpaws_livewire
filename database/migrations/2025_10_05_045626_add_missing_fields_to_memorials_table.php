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
        Schema::table('memorials', function (Blueprint $table) {
            $table->string('species', 100)->nullable()->after('pet_name');
            $table->string('breed', 100)->nullable()->after('species');
            $table->date('date_of_birth')->nullable()->after('breed');
            $table->date('date_of_passing')->nullable()->after('date_of_birth');
            $table->text('biography')->nullable()->after('story');
            $table->text('favorite_memory')->nullable()->after('biography');
            $table->json('personality')->nullable()->after('favorite_memory');
            $table->json('settings')->nullable()->after('theme');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('memorials', function (Blueprint $table) {
            $table->dropColumn([
                'species',
                'breed',
                'date_of_birth',
                'date_of_passing',
                'biography',
                'favorite_memory',
                'personality',
                'settings',
            ]);
        });
    }
};
