<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateGetFilteredScholarshipsProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE PROCEDURE `getFilteredScholarships`(
                IN `searchTerm` VARCHAR(255) CHARSET utf8mb4,
                IN `fundingTypes` VARCHAR(255) CHARSET utf8mb4,
                IN `countryIds` VARCHAR(255) CHARSET utf8mb4,
                IN `specializationIds` VARCHAR(255) CHARSET utf8mb4,
                IN `degreeLevelIds` VARCHAR(255) CHARSET utf8mb4,
                IN `limit_items` INT(11) UNSIGNED,
                IN `offset_items` INT(11) UNSIGNED
            )
            NOT DETERMINISTIC
            CONTAINS SQL
            SQL SECURITY DEFINER
            BEGIN
                SELECT
                    s.*,
                    (CASE
                        WHEN FIND_IN_SET(s.funding_type, fundingTypes COLLATE utf8mb4_unicode_ci) > 0 THEN 1 ELSE 0 END +
                        CASE
                            WHEN FIND_IN_SET(s.country_id, countryIds COLLATE utf8mb4_unicode_ci) > 0 THEN 1 ELSE 0 END +
                        CASE
                            WHEN EXISTS (
                                SELECT 1 FROM scholarship_specialization ss
                                WHERE ss.scholarship_id = s.id
                                AND FIND_IN_SET(ss.specialization_id , specializationIds COLLATE utf8mb4_unicode_ci) > 0
                            ) THEN 1 ELSE 0 END +
                        CASE
                            WHEN EXISTS (
                                SELECT 1 FROM scholarship_degree_level sdl
                                WHERE sdl.scholarship_id = s.id
                                AND FIND_IN_SET(sdl.degree_level_id, degreeLevelIds COLLATE utf8mb4_unicode_ci) > 0
                            ) THEN 1 ELSE 0 END
                    ) AS match_count
                FROM
                    scholarships s
                WHERE
                    (searchTerm = \'\' OR MATCH(s.title_ar, s.title_en, s.description_ar, s.description_en) AGAINST (searchTerm IN BOOLEAN MODE))
                HAVING
                    (match_count > 0 OR ( fundingTypes = \'\' AND countryIds = \'\' AND specializationIds = \'\' AND degreeLevelIds = \'\'))
                ORDER BY
                    match_count DESC
                LIMIT limit_items OFFSET offset_items;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP PROCEDURE IF EXISTS `getFilteredScholarships`');
    }
}
