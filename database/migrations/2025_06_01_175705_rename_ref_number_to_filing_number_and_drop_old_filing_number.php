<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('case_files', function (Blueprint $table) {
            $table->dropColumn('filing_number');
            $table->renameColumn('ref_number', 'filing_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('case_files', function (Blueprint $table) {
            $table->renameColumn('filing_number', 'ref_number');
            $table->string('filing_number');
        });
    }
};
