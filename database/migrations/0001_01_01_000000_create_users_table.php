<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 300);
            $table->string('middle_name', 255)->nullable();
            $table->string('last_name', 555);
            $table->string('email', 555)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('alternate_email', 555)->nullable();
            $table->string('mobile_no', 10)->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('mobile_otp')->nullable();
            $table->timestamp('otp_expiry')->nullable();
            $table->string('phone_no', 15)->nullable();
            $table->string('bar_code', 55)->nullable();
            $table->date('create_date')->nullable();
            $table->integer('usertype')->default(0);
            $table->integer('schema_id')->default(0);
            $table->unsignedBigInteger('online_filed_by')->nullable();
            $table->string('password');
            $table->string('secure_pin', 8)->nullable();
            $table->integer('question')->default(0);
            $table->text('answer')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
