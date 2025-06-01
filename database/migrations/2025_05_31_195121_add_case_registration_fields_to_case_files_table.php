<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCaseRegistrationFieldsToCaseFilesTable extends Migration
{
    public function up()
    {
        Schema::table('case_files', function (Blueprint $table) {
            $table->unsignedBigInteger('case_reg_no')->nullable()->after('filing_year');
            $table->year('case_reg_year')->nullable()->after('case_reg_no');
            $table->date('date_of_registration')->nullable()->after('case_reg_year');
            $table->enum('case_status', ['pending', 'disposed'])->default('pending')->after('date_of_registration');
            $table->date('date_of_disposal')->nullable()->after('case_status');

            $table->foreignId('court_id')->nullable()->constrained('courts')->after('date_of_disposal');
            $table->foreignId('judge_id')->nullable()->constrained('judges')->after('court_id');

            // Unique constraint for combination of reg_no and reg_year
            $table->unique(['case_reg_no', 'case_reg_year']);
        });
    }

    public function down()
    {
        Schema::table('case_files', function (Blueprint $table) {
            $table->dropUnique(['case_reg_no', 'case_reg_year']);
            $table->dropForeign(['court_id']);
            $table->dropForeign(['judge_id']);

            $table->dropColumn([
                'case_reg_no',
                'case_reg_year',
                'date_of_registration',
                'case_status',
                'date_of_disposal',
                'court_id',
                'judge_id',
            ]);
        });
    }
}