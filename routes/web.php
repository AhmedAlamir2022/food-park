<?php

use App\Http\Controllers\Frontend\WishlistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\FrontEnd\DashboardController;
use App\Http\Controllers\Frontend\PaymentController;



/** Show Home page */
Route::get('/', [FrontendController::class, 'index'])->name('home');

/** Chef page */
Route::get('/chef', [FrontendController::class, 'chef'])->name('chef');

/** Testimonial page */
Route::get('/testimonials', [FrontendController::class, 'testimonial'])->name('testimonial');

/** About Routes */
Route::get('/about', [FrontendController::class, 'about'])->name('about');

/** Contact Routes */
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact.index');
Route::post('/contact', [FrontendController::class, 'sendContactMessage'])->name('contact.send-message');

/** Reservation Routes */
Route::post('/reservation', [FrontendController::class, 'reservation'])->name('reservation.store');

/** Newsletter Routes */
Route::post('/subscribe-newsletter', [FrontendController::class, 'subscribeNewsletter'])->name('subscribe-newsletter');

/** Privacy Policy Routes */
Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('privacy-policy.index');

/** Trams and Conditions Routes */
Route::get('/trams-and-conditions', [FrontendController::class, 'tramsAndConditions'])->name('trams-and-conditions');

/** Blogs Routes */
Route::get('/blogs', [FrontendController::class, 'blog'])->name('blogs');
Route::get('/blogs/{slug}', [FrontendController::class, 'blogDetails'])->name('blogs.details');
Route::post('/blogs/comment/{blog_id}', [FrontendController::class, 'blogCommentStore'])->name('blogs.comment.store');

/** Product page Route*/
Route::get('/products', [FrontendController::class, 'products'])->name('product.index');

/** Show Product details page */
Route::get('/product/{slug}', [FrontendController::class, 'showProduct'])->name('product.show');

/** Product Modal Route */
Route::get('/load-product-modal/{productId}', [FrontendController::class, 'loadProductModal'])->name('load-product-modal');

Route::post('product-review', [FrontendController::class, 'productReviewStore'])->name('product-review.store');

/** Add to cart Route */
Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('get-cart-products', [CartController::class, 'getCartProduct'])->name('get-cart-products');
Route::get('cart-product-remove/{rowId}', [CartController::class, 'cartProductRemove'])->name('cart-product-remove');

/** Cart Page Routes */
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart-update-qty', [CartController::class, 'cartQtyUpdate'])->name('cart.quantity-update');
Route::get('/cart-destroy', [CartController::class, 'cartDestroy'])->name('cart.destroy');



/** Coupon Routes */
Route::post('/apply-coupon', [FrontendController::class, 'applyCoupon'])->name('apply-coupon');
Route::get('/destroy-coupon', [FrontendController::class, 'destroyCoupon'])->name('destroy-coupon');



Route::group(['middleware' => 'auth', 'role:user'], function () {
    /** dashboard routes */
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // profile routes
    Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');

    Route::post('address', [DashboardController::class, 'createAddress'])->name('address.store');
    Route::put('address/{id}/edit', [DashboardController::class, 'updateAddress'])->name('address.update');
    Route::delete('address/{id}', [DashboardController::class, 'destroyAddress'])->name('address.destroy');

    /** Wishlist Route */
    Route::get('wishlist/{productId}', [WishlistController::class, 'store'])->name('wishlist.store');

    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('checkout/{id}/delivery-cal', [CheckoutController::class, 'CalculateDeliveryCharge'])->name('checkout.delivery-cal');
    Route::post('checkout', [CheckoutController::class, 'checkoutRedirect'])->name('checkout.redirect');

    /** Payment Routes */
    Route::get('payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('make-payment', [PaymentController::class, 'makePayment'])->name('make-payment');
    Route::get('payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('payment-cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');

    /** PayPal Routes */
    Route::get('paypal/payment', [PaymentController::class, 'payWithPaypal'])->name('paypal.payment');
    Route::get('paypal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('paypal.cancel');

    /** Stripe Routes */
    Route::get('stripe/payment', [PaymentController::class, 'payWithStripe'])->name('stripe.payment');
    Route::get('stripe/success', [PaymentController::class, 'stripeSuccess'])->name('stripe.success');
    Route::get('stripe/cancel', [PaymentController::class, 'stripeCancel'])->name('stripe.cancel');

    /** Paymob Routes */
    // Route::get('paymob/payment', [PaymentController::class, 'payWithPaymob'])->name('paymob.payment');
    // Route::get('paymob/success', [PaymentController::class, 'paymobSuccess'])->name('paymob.success');
    // Route::get('paymob/cancel', [PaymentController::class, 'paymobCancel'])->name('paymob.cancel');
});

Route::group(['middleware' => 'auth'], function () {
});

require __DIR__ . '/auth.php';








Route::fallback(function () {
    return response()->view('page404');
});


// require __DIR__.'/admin.php';
