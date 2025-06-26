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
        Schema::create('case_proceedings', function (Blueprint $table) {
            $table->id();

            // Foreign key to case_files
            $table->unsignedBigInteger('case_file_id');

            // Purpose: link + snapshot
            $table->unsignedBigInteger('purpose_id')->nullable()->default(null);
            $table->string('purpose_name')->nullable(); // store original value

            // Bench info: link + snapshot
            $table->unsignedBigInteger('bench_id')->nullable()->default(null);
            $table->string('bench_name')->nullable(); // snapshot

            // Court No. and Listing
            $table->string('court_no')->nullable();
            $table->date('listing_date')->nullable();

            // Next list info
            $table->string('next_purpose')->nullable();
            $table->string('next_criteria')->nullable();
            $table->date('next_date')->nullable();

            // Action/Status
            $table->text('todays_action')->nullable();
            $table->string('todays_status')->nullable();

            $table->date('entry_date')->nullable();
            $table->text('remarks')->nullable();

            // User info
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->string('job_status')->nullable();

            // Party-related
            $table->string('party_type')->nullable();
            $table->string('adjournment')->nullable();
            $table->string('party_filed')->nullable();

            $table->text('ialist')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('case_file_id')->references('id')->on('case_files')->onDelete('cascade');
            $table->foreign('purpose_id')->references('id')->on('purpose_master')->onDelete('set null');
            $table->foreign('bench_id')->references('id')->on('bench_compositions')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_proceedings');
    }
};