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
        Schema::table('candidates', function (Blueprint $table) {
            $table->index('employee_id');
            $table->index('name');
            $table->index(['name', 'birthdate', 'first_working_day'], 'candidates_full_search_index');
        });

        Schema::table('candidatespict', function (Blueprint $table) {
            // candidate_id is already a foreign key, but let's ensure it has an index
            // (Laravel's foreignId(...)->constrained() already creates an index in most DBs)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropIndex(['employee_id']);
            $table->dropIndex(['name']);
            $table->dropIndex('candidates_full_search_index');
        });
    }
};
