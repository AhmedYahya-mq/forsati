<?php
namespace App\Providers;

use App\Models\Admin;
use App\Models\Advertisement; // استيراد نموذج Advertisement
use App\Models\Blog; // استيراد نموذج Blog
use App\Models\Scholarship; // استيراد نموذج Scholarship
use App\Models\Specialization; // استيراد نموذج Specialization
use App\Models\User; // استيراد نموذج User
use App\Policies\AdminPolicy; // استيراد Policy لـ User
use App\Policies\AdvertisementPolicy; // استيراد Policy لـ Advertisement
use App\Policies\BlogPolicy; // استيراد Policy لـ Blog
use App\Policies\ScholarshipPolicy; // استيراد Policy لـ Scholarship
use App\Policies\SpecializationPolicy; // استيراد Policy لـ Specialization
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * تتوفر مصفوفة تضم السياسات التي تحدد أذونات الوصول لنموذج معين.
     *
     * @var array
     */
    protected $policies = [
        Blog::class => BlogPolicy::class,
        Advertisement::class => AdvertisementPolicy::class,
        Specialization::class => SpecializationPolicy::class,
        Admin::class => AdminPolicy::class,
        User::class => UserPolicy::class,
        Scholarship::class => ScholarshipPolicy::class,

    ];

    /**
     * قم بتسجيل أي بوابات (Gates) أو سياسات (Policies) في هذا البرنامج.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
