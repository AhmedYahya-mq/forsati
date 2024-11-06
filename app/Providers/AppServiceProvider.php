<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\Admin;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use App\Events\AdminLoggedIn;
use App\Models\Advertisement;
use App\Events\AdminLoggedOut;
use App\Models\Specialization;
use App\Observers\BlogObserver;
use App\Listeners\LogAdminLogin;
use App\Observers\AdminObserver;
use App\Listeners\LogAdminLogout;
use App\Observers\ScholarshipObserver;
use App\Observers\AdvertisementObserver;
use Illuminate\Cache\RateLimiting\Limit;
use Laravel\Sanctum\PersonalAccessToken;
use App\Observers\SpecializationObserver;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard'; // قم بتغيير الصفحة الافتراضية هنا

    protected $listen = [
        AdminLoggedIn::class => [
            LogAdminLogin::class,
        ],
        AdminLoggedOut::class => [
            LogAdminLogout::class, // تسجيل Listener لتسجيل الخروج
        ],
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        // إعداد محدد معدل لنقطة نهاية الـ API
        RateLimiter::for(name: 'api', callback: function (Request $request): Limit {
            return Limit::perMinute(maxAttempts: 60); // ضبط عدد الطلبات المسموح بها في الدقيقة
        });
        // تسجيل الـ Observer
        Admin::observe(classes: AdminObserver::class);
        Specialization::observe(classes: SpecializationObserver::class);
        Advertisement::observe(classes: AdvertisementObserver::class);
        Blog::observe(classes: BlogObserver::class);
        Scholarship::observe(classes: ScholarshipObserver::class);
    }
}
