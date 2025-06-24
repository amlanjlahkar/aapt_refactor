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
        Schema::create('case_allocations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('case_file_id');

            $table->integer('serial_no')->nullable();

            $table->date('causelist_date');
            $table->string('causelist_type')->nullable();

            $table->unsignedBigInteger('purpose_id')->nullable()->default(null);
            $table->date('entry_date')->nullable();

            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->float('priority')->default(0);
            $table->text('remarks')->nullable();

            $table->string('listing_criteria', 20)->nullable();

            $table->unsignedBigInteger('bench_id')->nullable()->default(null);

            $table->enum('status', ['Draft', 'Prepared', 'Published'])->default('Draft');

            $table->unsignedBigInteger('published_by')->nullable();
            $table->timestamp('published_at')->nullable();

            // Foreign Keys
            $table->foreign('case_file_id')->references('id')->on('case_files')->onDelete('cascade');
            $table->foreign('purpose_id')->references('id')->on('purpose_master')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('bench_id')->references('id')->on('bench_compositions')->onDelete('set null');
            $table->foreign('published_by')->references('id')->on('admins')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_allocations');
    }
};