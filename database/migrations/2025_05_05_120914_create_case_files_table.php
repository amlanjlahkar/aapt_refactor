<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('case_files', function (Blueprint $table) {
            $table->id();
            $table->string('case_type')->default('Original Application');
            $table->string('bench')->default('Guwahati');
            $table->string('subject')->nullable();
            $table->boolean('legal_aid');
            $table->enum('filed_by', ['Advocate', 'Applicant in Person', 'Intervener']);
            $table->string('ref_number', 15)->unique();
            $table->string('filing_number');
            $table->date('filing_date');
            $table->integer('step')->default(1);
            $table->string('status')->default('Draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('case_files');
    }
};
