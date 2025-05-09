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
        Schema::create('case_files', function (Blueprint $table) {
            $table->id();
            $table->string('filing_no', 15)->unique();
            $table->date('filing_date');
            $table->string('filing_number');

            // New Fields
            $table->string('case_type')->default('original_application');
            $table->string('bench')->default('guwahati');
            $table->string('subject')->nullable();
            $table->boolean('legal_aid')->nullable();

            // Filed By
            $table->string('filed_by')->nullable();
            $table->integer('step')->default(1);
            $table->string('status')->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_files');
    }
};
