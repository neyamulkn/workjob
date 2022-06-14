<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/
define('SUPER_ADMIN', 1);

Route::get('404', 'FrontPagesController@error404')->name('404');
Auth::routes();

//SSLCOMMERZ END
Route::get('sitemap','SitemapController@index');
Route::get('sitemap.xml','SitemapController@index')->name('sitemap');
Route::get('sitemap.xml/pages','SitemapController@pages');
Route::get('sitemap.xml/products','SitemapController@products');
Route::get('sitemap.xml/categories','SitemapController@categories');

Route::get('category-sitemap', 'SitemapController@catSitemap')->name('category-sitemap');


Route::get('/', 'HomeController@index')->name('home')->middleware('auth');

Route::get('ads/{catslug?}/{location?}', 'HomeController@category')->name('home.category');
Route::get('location/{location}/{catslug?}', 'HomeController@location')->name('home.location');
//search products
Route::get('search', 'HomeController@category')->name('post.search');


//apply coupon
Route::get('coupon/apply', 'CartController@couponApply')->name('coupon.apply');
Route::get('ads/boost/{slug?}', 'PromotionController@boostPlan')->name('boostPlan');
//add to cart for direct buy
Route::post('buy/direct', 'CartController@buyDirect')->name('buyDirect');

Route::get('checkout/{buy_product_id?}', 'User\CheckoutController@checkout')->name('checkout')->middleware('auth');
Route::get('checkout/shipping/{buy_product_id?}', 'User\CheckoutController@shipping')->name('shipping');

Route::get('check/unique/value', 'AjaxController@checkField')->name('checkField');
//product quickview
Route::get('quickview/product/{product_id}', 'HomeController@quickview')->name('quickview');

//seller store routes
Route::get('profile/{username}', 'ShopController@userProfile')->name('userProfile');
Route::get('shop/{shop_name}/reviews', 'ShopController@shop_reviews')->name('seller_reviews');

Route::get('blog/{catSlug?}', 'FrontPagesController@blog')->name('blog');
Route::get('blog-details/{slug}', 'FrontPagesController@blog_details')->name('blog_details');
Route::get('blog/comment/insert', 'FrontPagesController@blog_comment_insert')->name('blog_comment_insert');
Route::get('blog/{slug}/comments', 'FrontPagesController@blog_comments')->name('blog_comments');

Route::get('more/{slug}', 'HomeController@moreProducts')->name('moreProducts');

//package routes
Route::get('package', 'PackagePurchaseController@index')->name('packagePlan');

Route::get('brand', 'FrontPagesController@topBrand')->name('topBrand');
Route::get('brand/{slug}', 'FrontPagesController@brandProducts')->name('brandProducts');
Route::get('today-deals', 'FrontPagesController@todayDeals')->name('todayDeals');
Route::get('faq', 'FrontPagesController@faq')->name('faq');
Route::get('{page}', 'FrontPagesController@page')->name('page');
Route::get('social-login/redirect/{provider}', 'SocialLoginController@redirectToProvider')->name('social.login');
Route::get('social-login/{provider}/callback', 'SocialLoginController@handleProviderCallback')->name('social.callback');


