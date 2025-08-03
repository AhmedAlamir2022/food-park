<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\AdminAuthController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\DeliveryAreaController;
use App\Http\Controllers\Backend\MenuBuilderController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductGalleryController;
use App\Http\Controllers\Backend\ProductOptionController;
use App\Http\Controllers\Backend\ProductSizeController;
use App\Http\Controllers\Backend\WhyChooseUsController;


Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'admin', 'as' => 'admin.'],function () {

    Route::get('dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');

    /** Profile Routes */
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    /** Slider Routes */
    Route::resource('slider', SliderController::class);

    /** Why choose us Routes */
    Route::put('why-choose-title-update', [WhyChooseUsController::class, 'updateTitle'])->name('why-choose-title.update');
    Route::resource('why-choose-us', WhyChooseUsController::class);

    /** Product Category Routes */
    Route::resource('category', CategoryController::class);

    /** Product Routes */
    Route::put('product-title-update', [ProductController::class, 'updateTitle'])->name('product-title.update');
    Route::resource('product', ProductController::class);

    /** Product Gallery Routes */
    Route::get('product-gallery/{product}', [ProductGalleryController::class, 'index'])->name('product-gallery.show-index');
    Route::resource('product-gallery', ProductGalleryController::class);

    /** Product Size Routes */
    Route::get('product-size/{product}', [ProductSizeController::class, 'index'])->name('product-size.show-index');
    Route::resource('product-size', ProductSizeController::class);

    /** Product Size Routes */
    Route::resource('product-option', ProductOptionController::class);

    /** Coupon Routes */
    Route::resource('coupon', CouponController::class);

    /** Delivery Area Routes */
    Route::resource('delivery-area', DeliveryAreaController::class);


    /** Setting Routes */
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/general-setting', [SettingController::class, 'UpdateGeneralSetting'])->name('general-setting.update');
    Route::put('/pusher-setting', [SettingController::class, 'UpdatePusherSetting'])->name('pusher-setting.update');
    Route::put('/mail-setting', [SettingController::class, 'UpdateMailSetting'])->name('mail-setting.update');
    Route::put('/logo-setting', [SettingController::class, 'UpdateLogoSetting'])->name('logo-setting.update');
    Route::put('/appearance-setting', [SettingController::class, 'UpdateAppearanceSetting'])->name('appearance-setting.update');
    Route::put('/seo-setting', [SettingController::class, 'UpdateSeoSetting'])->name('seo-setting.update');
});
