<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('case_id'); // Foreign key to case_files
            $table->enum('notice_type', ['1', '2', '3', '4', '5', '6']);
            $table->text('hearing_date');
            $table->timestamps();

            $table->foreign('case_id')->references('id')->on('case_files')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
