<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop old constraint only if it exists
        DB::statement('
            DO $$
            BEGIN
                IF EXISTS (
                    SELECT 1 FROM pg_constraint WHERE conname = \'scrutiny_filing_number_unique\'
                ) THEN
                    ALTER TABLE scrutiny DROP CONSTRAINT scrutiny_filing_number_unique;
                END IF;
            END
            $$;
        ');

        // Add composite unique constraint only if it doesn't exist
        DB::statement('
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1 FROM pg_constraint WHERE conname = \'unique_case_filing_level\'
                ) THEN
                    ALTER TABLE scrutiny ADD CONSTRAINT unique_case_filing_level
                    UNIQUE (case_file_id, filing_number, level);
                END IF;
            END
            $$;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop composite unique constraint only if it exists
        DB::statement('
            DO $$
            BEGIN
                IF EXISTS (
                    SELECT 1 FROM pg_constraint WHERE conname = \'unique_case_filing_level\'
                ) THEN
                    ALTER TABLE scrutiny DROP CONSTRAINT unique_case_filing_level;
                END IF;
            END
            $$;
        ');

        // Restore original unique constraint on filing_number
        DB::statement('
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1 FROM pg_constraint WHERE conname = \'scrutiny_filing_number_unique\'
                ) THEN
                    ALTER TABLE scrutiny ADD CONSTRAINT scrutiny_filing_number_unique
                    UNIQUE (filing_number);
                END IF;
            END
            $$;
        ');
    }
};
