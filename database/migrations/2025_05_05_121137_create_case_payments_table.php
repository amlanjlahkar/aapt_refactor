<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('case_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_file_id')->constrained()->onDelete('cascade');
            $table->enum('payment_mode', ['Demand Draft', 'Indian Post', 'Bharat Kosh']);
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('ref_no')->nullable();
            $table->date('ref_date')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_receipt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('case_payments');
    }
};
