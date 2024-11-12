<?php

use App\Models\Blog;
use App\Models\Admin;
use App\Models\Scholarship;
use App\Models\Advertisement;
use App\Models\Specialization;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\Customer\IndexController;
use App\Http\Controllers\SpecializationController;
use App\Http\Middleware\PoliciesDashboardMidleware;
use App\Http\Controllers\Customer\CommentController;
use App\Http\Controllers\Customer\BlogController as CustomerBlogController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\Customer\ScholarshipController as CustomerScholarshipController;


// admin routes ----------------------------------------------------------- //
Route::prefix('dashboard/admin/profile')->middleware('authuser:admin')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/upload-image-temp', [ProfileController::class, 'uploadImageTemp'])->name('profile.upload-image-temp');
    Route::delete('/delete-temp-image', [ProfileController::class, 'deleteTempImage'])->name('profile.delete-temp-image');
});

Route::prefix('dashboard/admin/users')->group(function () {
    require __DIR__.'/auth_admin.php';
});

Route::prefix('dashboard/admin')->middleware(['authuser:admin','admin'])->group(function () {
    Route::get('/', [DashboardController::class,"index"])->name('dashboard')->middleware([PoliciesDashboardMidleware::class]);
    Route::get('/content-manage', [AdvertisementController::class, "index"])->name('admin.contentmanager')->middleware('checkPolicy:checkPolicy,'.Advertisement::class);
    Route::get('user-manage', [AdminController::class, "index"] )->name('admin.usersManager.index')->middleware(['checkPolicy:checkPolicy,'.Admin::class]);
    Route::get('/specialization-manage', [SpecializationController::class, "index"])->name('admin.specializationManager')->middleware('checkPolicy:checkPolicy,'. Specialization::class);
    Route::get('/award-manage',[ScholarshipController::class, "index"])->name('admin.awardsManager')->middleware('checkPolicy:checkPolicy,'.Scholarship::class);;
    Route::get('/blog-manage',[BlogController::class, "index"])->name('admin.blogsManager')->middleware('checkPolicy:checkPolicy,'.Blog::class);
});



// user routes ---------------------------------------------------------------- //

require __DIR__.'/auth.php';
Route::get('lang/{lang?}', function ($lang=null) {

    $locale="ar";
    if($lang && in_array($lang, ['en', 'ar'])) {
        $locale=$lang;
    }else{
        // تبديل اللغة بين العربية والإنجليزية
        $locale = Cookie::get("locale") !== "en" ? "en" : $locale;
    }

    // تعيين اللغة وتخزينها في الكوكيز
    App::setLocale($locale);
    $cookie = Cookie::make(name: 'locale', value: $locale, minutes: 525600,secure: false); // تخزين اللغة في الكوكيز لمده سنة بدون تشفير

    // التحقق من الصفحة السابقة لتجنب التوجيه المتكرر
    $previousUrl = url()->previous();
    $currentUrl = url()->current();

    if ($previousUrl === $currentUrl) {
        return Redirect::to('/')->withCookie($cookie); // إعادة التوجيه إلى الصفحة الرئيسية مع تعيين الكوكي
    }

    return Redirect::back()->withCookie($cookie); // إعادة التوجيه إلى الصفحة السابقة مع تعيين الكوكي
})->name('change_language');

Route::prefix('')->middleware(['log.visits'])->group(function () {
    Route::get('/', IndexController::class)->name('home');
});

Route::prefix("blogs")->middleware(['log.visits'])->group(function ()  {
    Route::get('', CustomerBlogController::class)->name('blog');
    Route::get('/{slug}', [CustomerBlogController::class,"show"])->name('blog.details');
    Route::get('comments/{type}/{id}', CommentController::class)->name('blog.comments');
});

Route::prefix("scholarships")->middleware(['log.visits'])->group(function ()  {
    Route::get('', [CustomerScholarshipController::class,"index"])->name('scholarship.view');
    Route::get('/{slug}', [CustomerScholarshipController::class,"show"])->name('scholarship.details');
    Route::get('comments/{type}/{id}', CommentController::class)->name('scholarship.comments');
});


Route::prefix('profile')->middleware(['authuser','log.visits'])->name('profile')->group(function () {
    Route::get('', [CustomerProfileController::class,"index"])->name(name: '');
    Route::put('general', [CustomerProfileController::class,"general"])->name(name: '.general');
    Route::put('detail', [CustomerProfileController::class,"updateDetail"])->name(name: '.detail');
    Route::put('link', [CustomerProfileController::class,"updateLink"])->name(name: '.link');
    Route::put('notifications', [CustomerProfileController::class,"updateNotifications"])->name(name: '.notifications');
    Route::delete('/', [CustomerProfileController::class, 'destroy'])->name('.profile.destroy');
});
