<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('judge_master', function (Blueprint $table) {
            $table->id();
            $table->string('judge_name', 50)->nullable();
            $table->unsignedBigInteger('desg_id')->nullable();
            $table->integer('judge_code')->unique();
            $table->boolean('display')->default(true);
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('priority', 3)->nullable();
            $table->text('judge_short_name')->nullable();
            $table->timestamps();

            $table->foreign('desg_id')
                ->references('id')
                ->on('designation_master')
                ->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judge_master');
    }
};
