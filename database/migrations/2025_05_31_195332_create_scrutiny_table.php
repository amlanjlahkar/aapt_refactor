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
        Schema::create('scrutiny', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('case_file_id')->constrained()->onDelete('cascade');
            $table->string('filing_number', 15)->unique(); // Unique, NOT NULL
            $table->enum('objection_status', ['defect', 'defect_free'])->nullable(); 
            $table->string('other_objection', 500)->nullable();
            $table->enum('scrutiny_status', ['Pending', 'Forwarded', 'Rejected', 'Completed'])->nullable(); 
            $table->date('scrutiny_date')->nullable();
            $table->date('communication_date')->nullable();
            $table->date('compliance_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->unsignedBigInteger('user_id'); 
            $table->tinyInteger('level')->default(1); // 1 = Registry Reviewer, 2 = Section Officer, 3 = Dept Head
            $table->string('remarks_registry', 500)->nullable();
            $table->string('remarks_section_officer', 500)->nullable();
            $table->string('remarks_dept_head', 500)->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scrutiny');
    }
};