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
        Schema::create('bench_compositions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('court_no'); 
            $table->unsignedBigInteger('judge_id');
            $table->unsignedBigInteger('bench_type')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->boolean('display')->default(true);

            $table->timestamps();

            // Foreign keys
            $table->foreign('court_no')->references('id')->on('courts')->onDelete('cascade');
            $table->foreign('judge_id')->references('id')->on('judge_master')->onDelete('cascade');
            $table->foreign('bench_type')->references('id')->on('bench_types')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bench_compositions');
    }
};
