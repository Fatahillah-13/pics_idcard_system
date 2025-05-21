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
        Schema::table('candidatespict', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['employee_id']);

            // Rename the column
            $table->renameColumn('employee_id', 'candidate_id');
        });

        Schema::table('candidatespict', function (Blueprint $table) {
            // Re-add the foreign key constraint under the new name
            $table->foreign('candidate_id')->references('id')->on('candidates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidatespict', function (Blueprint $table) {
            $table->dropForeign(['candidate_id']);
            $table->renameColumn('candidate_id', 'employee_id');
        });

        Schema::table('candidatespict', function (Blueprint $table) {
            $table->foreign('employee_id')->references('id')->on('candidates')->onDelete('cascade');
        });
    }
};
