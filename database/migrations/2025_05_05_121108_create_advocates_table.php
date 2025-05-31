<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('advocates', function (Blueprint $table) {
            $table->id();
            $table->integer('adv_code')->primary();
            $table->string('name', 50);
            $table->string('bar_reg_no', 20)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('office_address', 100)->nullable();
            $table->string('adv_mobile', 20)->nullable();
            $table->string('adv_email', 40)->nullable();
            $table->char('gender', 1)->nullable();
            $table->string('telephone_no', 15)->nullable();
            $table->string('fax', 15)->nullable();
            $table->date('dob')->nullable();
            $table->char('display')->default('Y');
            $table->integer('state_code')->nullable();
            $table->integer('dist_code')->nullable();
            $table->string('pin_code', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('advocates');
    }
};
