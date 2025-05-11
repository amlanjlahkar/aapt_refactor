<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('petitioners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_file_id')->constrained()->onDelete('cascade');

            $table->enum('pet_type', ['individual', 'organization']);

            // Common Fields
            $table->string('pet_email');
            $table->string('pet_phone');
            $table->text('pet_address');

            // Individual Fields
            $table->string('pet_name')->nullable();
            $table->integer('pet_age')->nullable();
            $table->string('pet_state')->nullable();
            $table->string('pet_district')->nullable();

            // Organisation Fields
            $table->string('pet_ministry')->nullable();
            $table->string('pet_department')->nullable();
            $table->string('pet_contact_person')->nullable();
            $table->string('pet_designation')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('petitioners');
    }
};
