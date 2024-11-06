<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "title_en",
        "title_ar",
        "description_en",
        "description_ar",
        "funding_type",
        "content_ar",
        "content_en",
        "slug_ar",
        "slug_en",
        "admin_id",
        "visit",
        "deadline",
        "image",
        "funding_type",
        'country_id',
        "created_at"
    ];
    protected $table = 'scholarships';

    private static function  truncateText($text, $maxLength = 250) {
        if (mb_strlen($text) > $maxLength) {
            // قص النص وإضافة "..." في النهاية للدلالة على أن النص تم قطعه
            return mb_substr($text, 0, $maxLength) . '...'.substr($text, -2);
        }
        return $text;
    }

    public static function getFilteredScholarships($searchTerm, $fundingTypes, $countryIds, $specializationIds, $degreeLevelIds, $perPage = 10,$page=1)
    {
        // إنشاء مفتاح التخزين المؤقت بناءً على معلمات الإدخال
        $cacheKey = "{$perPage}{$page}{$searchTerm}{$fundingTypes}{$degreeLevelIds}{$specializationIds}{$countryIds}";
        $cacheKey=self::truncateText($cacheKey);
        // استرجاع البيانات من الكاش إذا كانت متاحة
            // بناء الاستعلام
            $query = Scholarship::query()
                ->select()
                ->with(['degree_levels', 'specializations']) // جلب العلاقات المرتبطة
                ->addSelect(DB::raw("
                    (
                        (CASE WHEN FIND_IN_SET(scholarships.funding_type, ?) > 0 THEN 1 ELSE 0 END) +
                        (CASE WHEN FIND_IN_SET(scholarships.country_id, ?) > 0 THEN 1 ELSE 0 END) +
                        (CASE WHEN EXISTS (
                            SELECT 1 FROM scholarship_specialization ss
                            WHERE ss.scholarship_id = scholarships.id
                            AND FIND_IN_SET(ss.specialization_id, ?)
                        ) THEN 1 ELSE 0 END) +
                        (CASE WHEN EXISTS (
                            SELECT 1 FROM scholarship_degree_level sdl
                            WHERE sdl.scholarship_id = scholarships.id
                            AND FIND_IN_SET(sdl.degree_level_id, ?)
                        ) THEN 1 ELSE 0 END)
                    ) as match_count
                "))
                ->addBinding([$fundingTypes, $countryIds, $specializationIds, $degreeLevelIds], 'select');

            // شرط البحث بالنصوص
            if (!empty($searchTerm)) {
                $query->whereRaw("MATCH(scholarships.title_ar, scholarships.title_en, scholarships.description_ar, scholarships.description_en) AGAINST (? IN BOOLEAN MODE)", [$searchTerm]);
            }

            // فلترة الشروط بناءً على وجود البيانات
            $query->havingRaw("(match_count > 0 OR ( ? = '' AND ? = '' AND ? = '' AND ? = ''))", [
                $fundingTypes, $countryIds, $specializationIds, $degreeLevelIds
            ]);

            // ترتيب النتائج بناءً على عدد التطابقات
            $query->orderBy('match_count', 'DESC');

            // تطبيق Pagination
            return $query->paginate($perPage);

    }


    /**
     * Get the comments for the scholarship.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class); // علاقة مع التعليقات
    }

    public function degree_levels()
    {
        return $this->belongsToMany(DegreeLevel::class, 'scholarship_degree_level');
    }

    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, 'scholarship_specialization');
    }


    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', '_id');
    }

    function formatVisits(): string
    {
        if ($this->visit < 1000) {
            return (string)$this->visit;
        } elseif ($this->visit < 1000000) {
            $result = $this->visit / 1000;
            return floor($result) . '.' . sprintf("%01d", ($result - floor($result)) * 10) . ' ألف';
        } elseif ($this->visit < 1000000000) {
            $result = $this->visit / 1000000;
            return floor($result) . '.' . sprintf("%01d", ($result - floor($result)) * 10) . ' مليون';
        } else {
            $result = $this->visit / 1000000000;
            return floor($result) . '.' . sprintf("%01d", ($result - floor($result)) * 10) . ' مليار';
        }
    }


}
