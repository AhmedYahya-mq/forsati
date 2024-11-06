<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Customer\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\SpecializationController;
use App\Models\Admin;
use App\Models\Advertisement;
use App\Models\Blog;
use App\Models\Scholarship;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




// api ادارة المستخدمين
Route::prefix('dashboard/admin/user-manage')->middleware(["auth:sanctum","admin",'can:checkPolicy,'.Admin::class])->group(function () {
    Route::put('state-users/{id}', [AdminController::class, 'updateAdminStatus'])->middleware("sanitizeInput");
    Route::put('email-verified-users/{id}', [AdminController::class, 'updateAdminEmailVerified'])->middleware("sanitizeInput");
    Route::get('', [AdminController::class, 'getAdmins']);
    Route::post("store",[AdminController::class, 'store'])->name('admin.usersManager.store')->middleware("sanitizeInput");
    Route::match(['put', 'patch'], 'update/{id}', [AdminController::class, 'update'])->middleware("sanitizeInput");
    Route::delete( 'destroy/{id}', [AdminController::class, 'destroy']);
    Route::get( 'edit/{id}', [AdminController::class, 'edit']);

});


//  api إدارة التخصصات
Route::prefix("dashboard/admin/specialization-manage")->middleware(["auth:sanctum","admin",'can:checkPolicy,'.Specialization::class])->group(function (){
    Route::post("store",[SpecializationController::class, 'store'])->name('admin.specializationManager.store')->middleware("sanitizeInput");
    Route::get('', [SpecializationController::class, "getSpecializations"])->name('admin.specializationManager.index');
    Route::delete( 'destroy/{id}', [SpecializationController::class, 'destroy'])->name('admin.specializationManager.destroy');
    Route::match(['put', 'patch'], 'update/{id}', [SpecializationController::class, 'update'])->name('admin.specializationManager.update')->middleware("sanitizeInput");
    Route::get( 'edit/{id}', [SpecializationController::class, 'edit']);

});


//  api إدارة التخصصات
Route::prefix("dashboard/admin/content-manage")->middleware(["auth:sanctum","admin",'can:checkPolicy,'.Advertisement::class])->group(function (){
    Route::post("store",[AdvertisementController::class, 'store'])->name('admin.advertisementManager.store')->middleware("sanitizeInput");
    Route::post('/upload-image-temp', [AdvertisementController::class, 'uploadImageTemp'])->name('advertisement.upload-image-temp');
    Route::delete('/delete-temp-image', [AdvertisementController::class, 'deleteTempImage'])->name('advertisement.delete-temp-image');
    Route::get('', [AdvertisementController::class, "getAdvertisements"])->name('admin.advertisementManager.index');
    Route::match(['put', 'patch'], 'update/{id}', [AdvertisementController::class, 'update'])->name('admin.advertisementManager.update')->middleware("sanitizeInput");
    Route::put('updateAdvertisementStatus/{id}', [AdvertisementController::class, 'updateAdvertisementStatus'])->middleware("sanitizeInput")
    ->name('admin.advertisementManager.updateAdvertisementStatus');
    Route::delete( 'destroy/{id}', [AdvertisementController::class, 'destroy'])->name('admin.advertisementManager.destroy');
    Route::get( 'edit/{id}', [AdvertisementController::class, 'edit']);

});


//إدارة المدونات Api
Route::prefix("dashboard/admin/blog-manage")->middleware(["auth:sanctum","admin",'can:checkPolicy,'.Blog::class])->group(function (){
    Route::post("store",[BlogController::class, 'store'])->name('admin.blogManager.store')->middleware("sanitizeInput");
    Route::post('/upload-image-temp', [BlogController::class, 'uploadImageTemp']);
    Route::get('', [BlogController::class, "getBlogs"]);
    Route::match(['put', 'patch'], 'update/{id}', [BlogController::class, 'update']);
    Route::delete( 'destroy/{id}', [BlogController::class, 'destroy']);
    Route::get( 'edit/{id}', [BlogController::class, 'edit']);
});


//إدارة المنح Api
Route::prefix("dashboard/admin/award-manage")->middleware(["auth:sanctum","admin",'can:checkPolicy,'.Scholarship::class])->group(function (){
    Route::post("store",[ScholarshipController::class, 'store'])->middleware("sanitizeInput");
    Route::post('/upload-image-temp', [ScholarshipController::class, 'uploadImageTemp']);
    Route::delete('/delete-temp-image', [ScholarshipController::class, 'deleteTempImage'])->name('scholarship.delete-temp-image');
    Route::get('', [ScholarshipController::class, "getScholarships"])->name('admin.scholarshipManager.index');
    Route::match(['put', 'patch'], 'update/{id}', [ScholarshipController::class, 'update'])->name('admin.scholarshipManager.update')->middleware("sanitizeInput");
    Route::delete( 'destroy/{id}', [ScholarshipController::class, 'destroy'])->name('admin.scholarshipManager.destroy');
    Route::get( 'edit/{id}', [ScholarshipController::class, 'edit'])->name('admin.scholarshipManager.show');
});


Route::prefix("dashboard/admin/")->middleware([])->group(function (){
    Route::get( 'get-visited', [DashboardController::class, 'getVisitedCountry']);
});

Route::prefix("blogs")->group(function ()  {
    Route::get('', [BlogController::class, "getBlogs"]);
    Route::get('comments/{type}/{id}', CommentController::class)->name('blog.comments');
    Route::post('comment', [CommentController::class, 'addComment'])->middleware("auth:web")->name('comments.store');
});
