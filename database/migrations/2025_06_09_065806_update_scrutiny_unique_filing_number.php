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
        Schema::table('scrutiny', function (Blueprint $table) {
            $table->dropUnique(['filing_number']); // drop global unique
            $table->unique(['case_file_id', 'filing_number', 'level'], 'unique_case_filing_level'); // add composite
        });
    }

    public function down(): void
    {
        Schema::table('scrutiny', function (Blueprint $table) {
            $table->dropUnique('unique_case_filing_level');
            $table->unique('filing_number');
        });
    }

};
