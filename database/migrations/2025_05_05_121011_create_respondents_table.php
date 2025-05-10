<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('respondents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_file_id')->constrained()->onDelete('cascade');

            $table->enum('res_type', ['individual', 'organization']);

            // Common Fields
            $table->string('res_email');
            $table->string('res_mobile');
            $table->text('res_address');

            // Individual Fields
            $table->string('res_name')->nullable();
            $table->integer('res_age')->nullable();
            $table->string('res_state')->nullable();
            $table->string('res_district')->nullable();

            // Organisation Fields
            $table->string('res_ministry')->nullable();
            $table->string('res_department')->nullable();
            $table->string('res_contact_person')->nullable();
            $table->string('res_designation')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('respondents');
    }
};
