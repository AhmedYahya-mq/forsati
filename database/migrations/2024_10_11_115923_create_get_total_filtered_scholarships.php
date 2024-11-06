<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateGetTotalFilteredScholarships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
    DROP PROCEDURE IF EXISTS `getTotalFilteredScholarships`;

    CREATE PROCEDURE `getTotalFilteredScholarships`(
        IN `searchTerm` VARCHAR(255),
        IN `fundingTypes` VARCHAR(255),
        IN `countryIds` VARCHAR(255),
        IN `specializationIds` VARCHAR(255),
        IN `degreeLevelIds` VARCHAR(255)
    )
    BEGIN
        SELECT COUNT(*) AS total_count
        FROM scholarships s
        WHERE
            (searchTerm = \'\' OR MATCH(s.title_ar, s.title_en, s.description_ar, s.description_en) AGAINST (searchTerm IN BOOLEAN MODE))
            AND (
                FIND_IN_SET(s.funding_type, fundingTypes COLLATE utf8mb4_unicode_ci) > 0 OR
                FIND_IN_SET(s.country_id , countryIds COLLATE utf8mb4_unicode_ci) > 0 OR
                EXISTS (
                    SELECT 1 FROM scholarship_specialization ss
                    WHERE ss.scholarship_id = s.id
                    AND FIND_IN_SET(ss.specialization_id , specializationIds COLLATE utf8mb4_unicode_ci) > 0
                ) OR
                EXISTS (
                    SELECT 1 FROM scholarship_degree_level sdl
                    WHERE sdl.scholarship_id = s.id
                    AND FIND_IN_SET(sdl.degree_level_id, degreeLevelIds COLLATE utf8mb4_unicode_ci) > 0
                )
            ) OR ( fundingTypes = \'\' AND countryIds = \'\' AND specializationIds = \'\' AND degreeLevelIds = \'\');
    END;
');


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP PROCEDURE IF EXISTS `getTotalFilteredScholarships`');
    }
}
