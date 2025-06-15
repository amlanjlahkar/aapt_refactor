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
        Schema::table('case_files', function (Blueprint $table) {
            $table->unsignedTinyInteger('scrutiny_level')->default(0); // or nullable() if needed
        });
    }

    public function down()
    {
        Schema::table('case_files', function (Blueprint $table) {
            $table->dropColumn('scrutiny_level');
        });
    }

};
