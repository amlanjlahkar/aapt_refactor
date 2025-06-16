<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateCaseStatusEnumInCaseFilesTable extends Migration
{
    public function up()
    {
        // Drop existing constraint
        DB::statement("ALTER TABLE case_files DROP CONSTRAINT IF EXISTS case_files_case_status_check");

        // Add updated constraint
        DB::statement("
            ALTER TABLE case_files
            ADD CONSTRAINT case_files_case_status_check
            CHECK (case_status IN ('pending', 'disposed', 'registered'))
        ");
    }

    public function down()
    {
        // Rollback to previous constraint
        DB::statement("ALTER TABLE case_files DROP CONSTRAINT IF EXISTS case_files_case_status_check");
        DB::statement("
            ALTER TABLE case_files
            ADD CONSTRAINT case_files_case_status_check
            CHECK (case_status IN ('pending', 'disposed'))
        ");
    }
}
