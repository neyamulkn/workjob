<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', 'Admin\AdminLoginController@LoginForm')->name('adminLoginForm');
Route::post('/login', 'Admin\AdminLoginController@login')->name('adminLogin');
Route::get('/register', 'Admin\AdminLoginController@RegisterForm')->name('adminRegisterForm');
Route::post('/register', 'Admin\AdminLoginController@register')->name('adminRegister');
Route::get('/logout', 'Admin\AdminLoginController@logout')->name('adminLogout');

Route::group(['middleware' => ['auth:admin', 'admin']], function(){
	//setting
	Route::get('general/setting', 'GeneralSettingController@generalSetting')->name('generalSetting');
	Route::post('general/setting/update/{id}', 'GeneralSettingController@generalSettingUpdate')->name('generalSettingUpdate');

	Route::get('logo/setting', 'GeneralSettingController@logoSetting')->name('logoSetting');
	Route::post('logo/setting/update/{id}', 'GeneralSettingController@logoSettingUpdate')->name('logoSettingUpdate');

	Route::match(['get', 'post'], 'google/setting', 'GeneralSettingController@googleSetting')->name('googleSetting');
	Route::match(['get', 'post'], 'google/recaptcha', 'SiteSettingController@google_recaptcha')->name('google_recaptcha');
	Route::match(['get', 'post'], 'seo/setting', 'GeneralSettingController@seoSetting')->name('seoSetting');
	Route::post('sitemap/setting','SitemapController@sitemapSetting')->name('sitemapSetting');

	Route::get('header/setting', 'GeneralSettingController@headerSetting')->name('headerSetting');
	Route::post('header/setting/update/{id}', 'GeneralSettingController@headerSettingUpdate')->name('headerSettingUpdate');
	Route::get('footer/setting', 'GeneralSettingController@footerSetting')->name('footerSetting');
	Route::post('footer/setting/update/{id}', 'GeneralSettingController@footerSettingUpdate')->name('footerSettingUpdate');

	
	Route::get('profile/update', 'Admin\AdminController@profileEdit')->name('admin.profileUpdate');
	Route::post('profile/update', 'Admin\AdminController@profileUpdate')->name('admin.profileUpdate');

	Route::get('change/password', 'Admin\AdminController@passwordChange')->name('admin.passwordChange');
	Route::post('change/password', 'Admin\AdminController@passwordUpdate')->name('admin.passwordChange');
	Route::post('reset/password', 'Admin\AdminController@resetPassword')->name('admin.resetPassword');

	Route::get('social/login/setting', 'Admin\SocialController@socialLoginSetting')->name('socialLoginSetting');
	Route::post('social/login/setting/update', 'Admin\SocialController@socialLoginSettingUpdate')->name('socialLoginSettingUpdate');

	Route::get('social/setting', 'Admin\SocialController@socialSetting')->name('socialSetting');
	Route::post('social/setting/store', 'Admin\SocialController@socialSettingStore')->name('socialSettingStore');
	Route::get('social/setting/edit/{id}', 'Admin\SocialController@socialSettingEdit')->name('socialSettingEdit');
	Route::post('social/setting/update/{id}', 'Admin\SocialController@socialSettingUpdate')->name('socialSettingUpdate');
	Route::get('social/setting/delete/{id}', 'Admin\SocialController@socialSettingDelete')->name('socialSettingDelete');

	// site setting
	Route::get('site/setting', 'SiteSettingController@siteSettings')->name('site_settings');
	Route::get('free/ads-limit/configurations', 'SiteSettingController@freeAdsLimit')->name('freeAdsLimit');
	Route::get('smtp/configurations', 'SiteSettingController@smtp_settings')->name('smtp_settings');
	Route::match(['get', 'post'], 'otp/configurations', 'SiteSettingController@otp_configurations')->name('otp_configurations');
	Route::post('env_key_update', 'SiteSettingController@env_key_update')->name('env_key_update');

	Route::get('site/setting/update/status', 'SiteSettingController@siteSettingActiveDeactive')->name('siteSettingActiveDeactive');
	Route::match(['get', 'post'], 'site/setting/update', 'SiteSettingController@siteSettingUpdate')->name('siteSettingUpdate');

	//refund
	Route::get('refund/request/{status?}', 'RefundController@adminReturnRequestList')->name('admin.refundRequest');
	Route::get('refund/request/status/{id}', 'RefundController@refundRequestStatus')->name('admin.refundRequestStatus');
	Route::get('refund/request/details/{id}', 'RefundController@refundRequestDetails')->name('admin.refundRequestDetails');
	Route::get('refund/request/approved/{id}/{status}', 'RefundController@refundRequestApproved')->name('admin.refundRequestApproved');

	//seller withdraw request
	Route::get('seller/withdraw/request', 'WithdrawController@sellerWithdrawRequest')->name('sellerWithdrawRequest');
	Route::get('seller/wallet/history', 'Admin\WalletController@sellerWalletHistory')->name('sellerWalletHistory');


	//customer withdraw request list
	Route::get('customer/wallet/withdraw/request', 'WithdrawController@customerWithdrawRequest')->name('customerWithdrawRequest')->middleware('adminPermission');
	Route::get('customer/wallet/history', 'Admin\WalletController@customerWalletHistory')->name('customerWalletHistory')->middleware('adminPermission');

	Route::get('customer/wallet/information', 'Admin\WalletController@customerWalletInfo')->name('customer.walletInfo');
	Route::post('customer/wallet/recharge', 'Admin\WalletController@walletRecharge')->name('customer.walletRecharge')->middleware('adminPermission');

	Route::get('customer/wallet/withdraw/configuration', 'WithdrawController@customerWithdrawConfigure')->name('customer.withdrawConfigure');

	Route::match(['GET', 'POST'], '/defualt/safety/tip', 'SiteSettingController@safety_tip')->name('safety_tip');

	Route::match(['get','post'], 'withdraw/request/update', 'Admin\WalletController@changeWithdrawStatus')->name('admin.changeWithdrawStatus');
	Route::get('withdraw/make/withdraw/details/{withdraw_id}', 'Admin\WalletController@withdrawMakePaymentDetails')->name('admin.withdrawMakePaymentDetails');
	Route::get('withdraw/history/{user_id}', 'Admin\WalletController@getWithdrawHistory')->name('admin.getWithdrawHistory');
	Route::get('transactions', 'TransactionController@admin_transactions')->name('admin.transactions');


	//product review
	route::get('post/review', 'ReviewController@reviewList')->name('adminReviewList');

	route::get('package/review/form', 'ReviewController@adminGetReviewForm')->name('adminGetReviewForm');
	route::post('package/review/insert', 'ReviewController@adminReviewInsert')->name('adminReviewInsert');

	//insert fake review
	route::post('post/review/insert', 'ReviewController@reviewInsert')->name('productReviewInsert');
	
	route::get('post/review/edit/{id}', 'ReviewController@reviewEdit')->name('adminReviewEdit');
	route::post('post/review/update', 'ReviewController@reviewUpdate')->name('adminReviewUpdate');
	route::get('post/review/delete/{id}', 'ReviewController@reviewDelete')->name('adminReviewDelete');
	route::get('post/review/reply/{id}', 'ReviewController@reviewReplyList')->name('reviewReplyList');
	route::post('post/review/reply/{id}', 'ReviewController@reviewReply')->name('reviewReply');


	// brand routes
	Route::get('brand', 'BrandController@index')->name('brand');
	Route::post('brand/store', 'BrandController@store')->name('brand.store');
	Route::get('brand/list', 'BrandController@index')->name('brand.list');
	Route::get('brand/edit/{id}', 'BrandController@edit')->name('brand.edit');
	Route::post('brand/update', 'BrandController@update')->name('brand.update');
	Route::get('brand/delete/{id}', 'BrandController@delete')->name('brand.delete');
	// currency route
	Route::get('currency/list', 'CurrencyController@index')->name('currency.list');
	Route::post('currency/store', 'CurrencyController@store')->name('currency.store');
	Route::get('currency/edit/{id}', 'CurrencyController@edit')->name('currency.edit');
	Route::post('currency/update', 'CurrencyController@update')->name('currency.update');
	Route::get('currency/delete/{id}', 'CurrencyController@delete')->name('currency.delete');
	Route::get('currency/default/set', 'CurrencyController@currencyDefaultSet')->name('currency.defaultSet');



	// reject reason route
	
	Route::get('reject/reason/list', 'RejectReasonController@rejectReason')->name('rejectReason.list');
	Route::post('reject/reason/store', 'RejectReasonController@rejectReasonStore')->name('rejectReason.store');
	Route::get('reject/reason/edit/{id}', 'RejectReasonController@rejectReasonEdit')->name('rejectReason.edit');
	Route::post('reject/reason/update', 'RejectReasonController@rejectReasonUpdate')->name('rejectReason.update');
	Route::get('reject/reason/delete/{id}', 'RejectReasonController@rejectReasonDelete')->name('rejectReason.delete');

	// report reason route
	Route::get('report/{type?}', 'ReportController@reports')->name('report.list');
	Route::get('report/reason/list', 'ReportController@reportReason')->name('reportReason.list');
	Route::post('report/reason/store', 'ReportController@reasonStore')->name('reportReason.store');
	Route::get('report/reason/edit/{id}', 'ReportController@reasonEdit')->name('reportReason.edit');
	Route::post('report/reason/update', 'ReportController@reasonUpdate')->name('reportReason.update');
	Route::get('report/reason/delete/{id}', 'ReportController@reasonDelete')->name('reportReason.delete');


});

// authenticate routes & check role admin
Route::group(['middleware' => 'auth:admin', 'namespace' => 'Admin'], function(){
	Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');
	//module
	Route::get('module/list', 'ModuleController@index')->name('module.list');
	Route::post('module/store', 'ModuleController@store')->name('admin.module.store');
	Route::get('module/edit/{id}', 'ModuleController@edit')->name('admin.module.edit');
	Route::post('module/update', 'ModuleController@update')->name('admin.module.update');
	Route::get('module/delete/{id}', 'ModuleController@delete')->name('admin.module.delete');	

	//sub module
	Route::get('submodule/list', 'ModuleController@submoduleIndex')->name('admin.submodule.list');
	Route::post('submodule/store', 'ModuleController@submoduleStore')->name('admin.submodule.store');
	Route::get('submodule/edit/{id}', 'ModuleController@submoduleEdit')->name('admin.submodule.edit');
	Route::post('submodule/update', 'ModuleController@submoduleUpdate')->name('admin.submodule.update');
	Route::get('submodule/delete/{id}', 'ModuleController@submoduleDelete')->name('admin.submodule.delete');

	// role routes
	Route::get('role/list', 'RoleController@index')->name('role.list');
	Route::post('role/store', 'RoleController@store')->name('role.store');
	Route::get('role/{id}/edit', 'RoleController@edit')->name('role.edit');
	Route::post('role/update', 'RoleController@update')->name('role.update');
	Route::get('role/delete/{id}', 'RoleController@delete')->name('role.delete');
	
	Route::get('role/permission/{slug}', 'RoleController@permissionIndex')->name('role.permission');
	Route::post('role/permission/store', 'RoleController@permissionStore')->name('role.permission.store');


	// adspackage routes
	Route::get('packages', 'PackageController@package_create')->name('adspackage');
	Route::post('package/store', 'PackageController@package_store')->name('adspackage.store');

	Route::get('package/edit/{id}', 'PackageController@package_edit')->name('adspackage.edit');
	Route::post('package/update', 'PackageController@package_update')->name('adspackage.update');
	Route::get('package/delete/{id}', 'PackageController@package_delete')->name('adspackage.delete');

	// adspackageValue routes
	Route::get('ads/packagevalue/{package_slug}/list', 'PackageController@packagevalue')->name('adspackageValue');
	Route::post('ads/packagevalue/store', 'PackageController@packagevalue_store')->name('adspackageValue.store');
	Route::get('ads/packagevalue/list', 'PackageController@packagevalue_list')->name('adspackageValue.list');
	Route::get('ads/packagevalue/edit/{id}', 'PackageController@packagevalue_edit')->name('adspackageValue.edit');
	Route::post('ads/packagevalue/update', 'PackageController@packagevalue_update')->name('adspackageValue.update');
	Route::get('ads/packagevalue/delete/{id}', 'PackageController@packagevalue_delete')->name('adspackageValue.delete');
	Route::get('free/ads/limit', 'PackageController@freeAdsLimit')->name('admin.setAdsLimit');


	Route::prefix('advertisement')->name('addvertisement.')->group( function(){
        Route::get('list', 'AddvertisementController@index')->name('list');
		Route::get('create', 'AddvertisementController@create')->name('create');
		Route::post('store', 'AddvertisementController@store')->name('store');
		Route::get('edit/{id}', 'AddvertisementController@edit')->name('edit');
		Route::post('update', 'AddvertisementController@update')->name('update');
		Route::get('delete/{id}', 'AddvertisementController@delete')->name('delete');
	});

	//category routes
	Route::get('category', 'CategoryController@category')->name('category');
	Route::get('get/category', 'CategoryController@getcategory')->name('getcategory');
	Route::post('category/store', 'CategoryController@category_store')->name('category.store');
	Route::get('category/edit/{id}', 'CategoryController@category_edit')->name('category.edit');
	Route::post('category/update', 'CategoryController@category_update')->name('category.update');
	Route::get('category/delete/{id}', 'CategoryController@category_delete')->name('category.delete');
	Route::match(['GET', 'POST'], 'safety/tip/{id?}', 'CategoryController@safety_tip')->name('cat_safety_tip');

	// sub category routes
	Route::get('subcategory', 'CategoryController@subcategory')->name('subcategory');

	Route::post('subcategory/store', 'CategoryController@subcategory_store')->name('subcategory.store');
	Route::get('subcategory/list', 'CategoryController@subcategory_index')->name('subcategory.list');
	Route::get('subcategory/edit/{id}', 'CategoryController@subcategory_edit')->name('subcategory.edit');
	Route::post('subcategory/update', 'CategoryController@subcategory_update')->name('subcategory.update');
	Route::get('subcategory/delete/{id}', 'CategoryController@subcategory_delete')->name('subcategory.delete');

	Route::get('get/subcategory/{id}', 'CategoryController@get_subcategory')->name('get_subcategory');

	Route::get('subchild/category', 'CategoryController@subchildcategory')->name('subchildcategory');
	Route::post('subchild/category/store', 'CategoryController@subchildcategory_store')->name('subchildcategory.store');

	Route::get('subchild/category/edit/{id}', 'CategoryController@subchildcategory_edit')->name('subchildcategory.edit');

	Route::post('subchild/category/update', 'CategoryController@subchildcategory_update')->name('subchildcategory.update');
	Route::get('subchild/category/delete/{id}', 'CategoryController@subchildcategory_delete')->name('subchildcategory.delete');

	Route::get('category/sorting', 'CategoryController@categorySorting')->name('categorySorting');
	Route::get('get/category/banner/{slug}', 'CategoryController@getCategoryBanner')->name('getCategoryBanner');

		// productAttribute routes
	Route::get('post/attribute', 'ProductAttributeController@attribute_create')->name('productAttribute');
	Route::post('post/attribute/store', 'ProductAttributeController@attribute_store')->name('productAttribute.store');

	Route::get('post/attribute/edit/{id}', 'ProductAttributeController@attribute_edit')->name('productAttribute.edit');
	Route::post('post/attribute/update', 'ProductAttributeController@attribute_update')->name('productAttribute.update');
	Route::get('post/attribute/delete/{id}', 'ProductAttributeController@attribute_delete')->name('productAttribute.delete');

	// productAttributeValue routes
	Route::get('post/attributevalue/{attribute_slug}/list', 'ProductAttributeController@attributevalue')->name('productAttributeValue');
	Route::post('post/attributevalue/store', 'ProductAttributeController@attributevalue_store')->name('productAttributeValue.store');
	Route::get('post/attributevalue/list', 'ProductAttributeController@attributevalue_list')->name('productAttributeValue.list');
	Route::get('post/attributevalue/edit/{id}', 'ProductAttributeController@attributevalue_edit')->name('productAttributeValue.edit');
	Route::post('post/attributevalue/update', 'ProductAttributeController@attributevalue_update')->name('productAttributeValue.update');
	Route::get('post/attributevalue/delete/{id}', 'ProductAttributeController@attributevalue_delete')->name('productAttributeValue.delete');

	// predefined Feature routes
	Route::get('predefined/feature', 'PredefinedFeatureController@index')->name('predefinedFeature');
	Route::post('predefined/feature/store', 'PredefinedFeatureController@store')->name('predefinedFeature.store');
	Route::get('predefined/feature/list', 'PredefinedFeatureController@index')->name('predefinedFeature.list');
	Route::get('predefined/feature/edit/{id}', 'PredefinedFeatureController@edit')->name('predefinedFeature.edit');
	Route::post('predefined/feature/update', 'PredefinedFeatureController@update')->name('predefinedFeature.update');
	Route::get('predefined/feature/delete/{id}', 'PredefinedFeatureController@delete')->name('predefinedFeature.delete');


	// product routes
	Route::get('post/upload', 'ProductController@upload')->name('admin.product.upload');
	Route::post('post/store', 'ProductController@store')->name('admin.product.store');
	Route::get('post/{status?}', 'ProductController@index')->name('admin.product.list');
	Route::get('post/edit/{slug}', 'ProductController@edit')->name('admin.product.edit');
	Route::post('post/update/{product_id}', 'ProductController@update')->name('admin.product.update');
	Route::get('post/delete/{id}', 'ProductController@delete')->name('admin.product.delete');
	//get highlight popup
	Route::get('post/status/popup/{id}', 'ProductController@productStatus')->name('productStatus');
 	//add/remove highlight product
	Route::post('post/status/update', 'ProductController@productStatusUpdate')->name('productStatusUpdate');
	//upload product gallery image
	Route::get('post/gallery/image/{product_id}', 'ProductController@getGalleryImage')->name('product.getGalleryImage');
	Route::post('post/gallery/image', 'ProductController@storeGalleryImage')->name('product.storeGalleryImage');
	Route::get('post/gallery/image/delete/{id}', 'ProductController@deleteGalleryImage')->name('product.deleteGalleryImage');

	// product routes
	Route::get('blog/create', 'BlogController@create')->name('admin.blog.upload');
	Route::post('blog/store', 'BlogController@store')->name('admin.blog.store');
	Route::get('blog/{status?}', 'BlogController@index')->name('admin.blog.list');
	Route::get('blog/edit/{slug}', 'BlogController@edit')->name('admin.blog.edit');
	Route::post('blog/update/{product_id}', 'BlogController@update')->name('admin.blog.update');
	Route::get('blog/delete/{id}', 'BlogController@delete')->name('admin.blog.delete');

	// slider routes
	Route::get('slider/create', 'SliderController@index')->name('slider.create');
	Route::post('slider/store', 'SliderController@store')->name('slider.store');
	Route::get('manage/slider', 'SliderController@index')->name('slider.list');
	Route::get('slider/edit/{id}', 'SliderController@edit')->name('slider.edit');
	Route::post('slider/update', 'SliderController@update')->name('slider.update');
	Route::get('slider/delete/{id}', 'SliderController@delete')->name('slider.delete');


	// homepage routes
	Route::get('homepage/section', 'HomepageSectionController@index')->name('admin.homepageSection');
	Route::post('homepage/section/store', 'HomepageSectionController@store')->name('admin.homepageSection.store');
	Route::get('homepage/section/edit/{id}', 'HomepageSectionController@edit')->name('admin.homepageSection.edit');
	Route::post('homepage/section/update', 'HomepageSectionController@update')->name('admin.homepageSection.update');
	Route::get('homepage/section/delete/{id}', 'HomepageSectionController@delete')->name('admin.homepageSection.delete');
	Route::get('homepage/section/image/delete/{id}', 'HomepageSectionController@sectionImageDelete')->name('sectionImageDelete');

	// homepage section routes
	Route::get('homepage/section/item/{slug?}', 'HomepageSectionItemController@index')->name('admin.homepageSectionItem');
	Route::post('homepage/section/item/store', 'HomepageSectionItemController@store')->name('admin.homepageSectionItem.store');
	Route::get('homepage/section/item/edit/{id}', 'HomepageSectionItemController@edit')->name('admin.homepageSectionItem.edit');
	Route::post('homepage/section/item/update', 'HomepageSectionItemController@update')->name('admin.homepageSectionItem.update');
	Route::get('homepage/section/item/remove/{id}', 'HomepageSectionItemController@itemRemove')->name('admin.homepageSectionItem.remove');

	Route::get('homepage/section/get/single-product', 'HomepageSectionController@getSingleProduct')->name('admin.getSingleProduct');

	Route::get('homepage/section/sorting', 'HomepageSectionController@homepageSectionSorting')->name('admin.homepageSectionSorting');

	// category section routes
	Route::get('category/section', 'CategorySectionController@index')->name('admin.categorySection');
	Route::post('category/section/store', 'CategorySectionController@store')->name('admin.categorySection.store');
	Route::get('category/section/edit/{id}', 'CategorySectionController@edit')->name('admin.categorySection.edit');
	Route::post('category/section/update', 'CategorySectionController@update')->name('admin.categorySection.update');
	Route::get('category/section/delete/{id}', 'CategorySectionController@delete')->name('admin.categorySection.delete');
	Route::get('get/sub-child-category', 'CategorySectionController@getSubChildcategory')->name('admin.getSubChildcategory');


	// offer routes
	Route::get('offer/type/list', 'OfferTypeController@offerTypeIndex')->name('offerType.list');
	Route::post('offer/type/store', 'OfferTypeController@offerTypeStore')->name('offerType.store');
	Route::get('offer/type/{id}/edit', 'OfferTypeController@offerTypeEdit')->name('offerType.edit');
	Route::post('offer/type/update', 'OfferTypeController@offerTypeUpdate')->name('offerType.update');
	Route::get('offer/type/delete/{id}', 'OfferTypeController@offerTypeDelete')->name('offerType.delete');

	Route::get('offer', 'OfferController@index')->name('admin.offer');
	Route::post('offer/store', 'OfferController@store')->name('admin.offer.store');
	Route::get('offer/list', 'OfferController@index')->name('admin.offer.list');
	Route::get('offer/edit/{id}', 'OfferController@editOffer')->name('admin.offer.edit');
	Route::post('offer/update', 'OfferController@updateOffer')->name('admin.offer.update');
	Route::get('offer/delete/{id}', 'OfferController@delete')->name('admin.offer.delete');
	//get product ajax request
	Route::get('offer/get/all/product', 'OfferController@getAllProducts')->name('offer.getAllProducts');

	//disply offer product list
	Route::get('offer/{offer_slug}/product', 'OfferController@offerProducts')->name('admin.offerProducts')->middleware('adminPermission');
	Route::get('offer/post/edit/{id}', 'OfferController@offerProductEdit')->name('admin.offerProduct.edit');
	Route::post('offer/post/update', 'OfferController@offerProductUpdate')->name('admin.offerProduct.update');
	Route::get('offer/post/remove/{id}', 'OfferController@offerProductRemove')->name('admin.offerProduct.remove');
	Route::get('offer/post/seller/price/{id}', 'OfferController@setProductPrice')->name('admin.setProductPrice');

	Route::get('offer/single/post/store', 'OfferController@offerSingleProductStore')->name('admin.offerSingleProductStore');
	Route::post('offer/post/store', 'OfferController@offerMultiProductStore')->name('admin.offerMultiProductStore');
	Route::post('offer/post/store', 'OfferController@offerMultiProductStore')->name('admin.offerMultiProductStore');

	Route::get('offer/{offer_slug}/package/{status?}', 'OfferController@offerpackage')->name('admin.offerpackage');
	Route::get('offer/{offer_slug}/package/details/{username}', 'OfferController@showOfferpackageDetails')->name('admin.getOfferpackageDetails');

	Route::get('offer/{offer_slug}/package/invoice/{customer_name}', 'OfferController@offerpackageInvoice')->name('admin.offerpackageInvoice');

	Route::get('offer/{offer_slug}/post/{product_slug}', 'OfferController@offerpackageProducts')->name('admin.offerpackageProducts');


	// page routes
	Route::get('page/create', 'PageController@create')->name('page.create');
	Route::post('page/store', 'PageController@store')->name('page.store');
	Route::get('page/list', 'PageController@index')->name('page.list');
	Route::get('page/{slug}/edit', 'PageController@edit')->name('page.edit');
	Route::post('page/update/{id}', 'PageController@update')->name('page.update');
	Route::get('page/delete/{id}', 'PageController@delete')->name('page.delete');
	Route::get('page/slug/create', 'PageController@getSlug')->name('page.slug');

	Route::get('page/status/{id}', 'PageController@status')->name('page.status');
	Route::get('page/homepage-status/{id}', 'PageController@homepageStatus')->name('page.homepageStatus');

	Route::post('faq/store', 'FaqController@store')->name('faq.store');
	Route::get('faq/list', 'FaqController@index')->name('faq.list');
	Route::get('faq/edit/{id}', 'FaqController@edit')->name('faq.edit');
	Route::post('faq/update', 'FaqController@update')->name('faq.update');
	Route::get('faq/delete/{id}', 'FaqController@delete')->name('faq.delete');



	// menu routes
	Route::get('menu', 'MenuController@index')->name('menu');
	Route::post('menu/store', 'MenuController@store')->name('menu.store');
	Route::get('menu/list', 'MenuController@index')->name('menu.list');
	Route::get('menu/edit/{id}', 'MenuController@edit')->name('menu.edit');
	Route::post('menu/update', 'MenuController@update')->name('menu.update');
	Route::get('menu/delete/{id}', 'MenuController@delete')->name('menu.delete');

	// user routes

	Route::post('user/store', 'CustomerController@store')->name('customer.store');
	Route::get('user/{id}/edit', 'CustomerController@edit')->name('customer.edit');
	Route::post('user/update', 'CustomerController@update')->name('customer.update');
	Route::get('user/delete/{id}', 'CustomerController@delete')->name('customer.delete');

	Route::get('user/list/{status?}', 'CustomerController@customerList')->name('customer.list');
	Route::get('user/secret/login/{id}', 'CustomerController@customerSecretLogin')->name('admin.customerSecretLogin');
	Route::get('user/profile/{username}', 'CustomerController@customerProfile')->name('customer.profile');

	Route::get('user/status/{id}', 'CustomerController@customerStatus')->name('customerStatus');
	Route::post('user/status', 'CustomerController@customerStatusUpdate')->name('customerStatusUpdate');
	Route::get('user/verify/request', 'CustomerController@verifyRequest')->name('userVerifyRequest');


	// designation routes
	Route::get('designation/create', 'DesignationController@create')->name('designation.create');
	Route::post('designation/store', 'DesignationController@store')->name('designation.store');
	Route::get('designation/list', 'DesignationController@index')->name('designation.list');
	Route::get('designation/{id}/edit', 'DesignationController@edit')->name('designation.edit');
	Route::post('designation/update', 'DesignationController@update')->name('designation.update');
	Route::get('designation/delete/{id}', 'DesignationController@delete')->name('designation.delete');


	// banner routes
	Route::get('banner/list/{type?}', 'BannerController@index')->name('banner');
	Route::post('banner/store', 'BannerController@store')->name('banner.store');

	Route::get('banner/{id}/edit', 'BannerController@edit')->name('banner.edit');
	Route::post('banner/update', 'BannerController@update')->name('banner.update');
	Route::get('banner/delete/{id}', 'BannerController@delete')->name('banner.delete');
	Route::get('banner/image/delete', 'BannerController@bannerImage_delete')->name('bannerImage_delete');

	// label routes
	Route::post('label/store', 'LabelController@store')->name('label.store');
	Route::get('label/list', 'LabelController@index')->name('label.list');
	Route::get('label/{id}/edit', 'LabelController@edit')->name('label.edit');
	Route::post('label/update', 'LabelController@update')->name('label.update');
	Route::get('label/delete/{id}', 'LabelController@delete')->name('label.delete');


	//state
	Route::get('state', 'LocationController@state')->name('state');
	Route::post('state/store', 'LocationController@state_store')->name('state.store');
	Route::get('state/edit/{id}', 'LocationController@state_edit')->name('state.edit');
	Route::post('state/update', 'LocationController@state_update')->name('state.update');
	Route::get('state/delete/{id}', 'LocationController@state_delete')->name('state.delete');

	// city route
	Route::get('city', 'LocationController@city')->name('city');
	Route::post('city/store', 'LocationController@city_store')->name('city.store');
	Route::get('city/edit/{id}', 'LocationController@city_edit')->name('city.edit');
	Route::post('city/update', 'LocationController@city_update')->name('city.update');
	Route::get('city/delete/{id}', 'LocationController@city_delete')->name('city.delete');

	// area route
	Route::get('area', 'LocationController@area')->name('area');
	Route::post('area/store', 'LocationController@area_store')->name('area.store');
	Route::get('area/edit/{id}', 'LocationController@area_edit')->name('area.edit');
	Route::post('area/update', 'LocationController@area_update')->name('area.update');
	Route::get('area/delete/{id}', 'LocationController@area_delete')->name('area.delete');

	// payment route
	Route::get('payment/gateway', 'PaymentGatewayController@index')->name('paymentGateway');
	Route::post('payment/gateway/store', 'PaymentGatewayController@store')->name('paymentGateway.store');
	Route::get('payment/gateway/edit/{id}', 'PaymentGatewayController@edit')->name('paymentGateway.edit');
	Route::post('payment/gateway/update', 'PaymentGatewayController@update')->name('paymentGateway.update');
	Route::get('payment/gateway/delete/{id}', 'PaymentGatewayController@delete')->name('paymentGateway.delete');
	Route::get('payment/gateway/mode/change', 'PaymentGatewayController@paymentModeChange')->name('paymentModeChange');
	//seller payment route
	Route::get('payment/gateway/seller', 'PaymentGatewayController@sellerPaymentGateway')->name('sellerPaymentGateway');
	//package lis
	Route::get('purchase/package/{status?}', 'PurchasePackageController@packageHistory')->name('admin.packageList');

		//change payment status
	Route::post('package/payment/status/change', 'PurchasePackageController@changePaymentStatus')->name('changePaymentStatus');
	Route::get('package/payment/details/check/{order_id}', 'PurchasePackageController@packagePaymentDetails')->name('packagePaymentDetails');

	Route::get('purchase/package/details/{package_id}', 'PurchasePackageController@showpackageDetails')->name('admin.getpackageDetails');
	Route::get('purchase/package/invoice/{package_id?}', 'PurchasePackageController@packageInvoice')->name('admin.packageInvoice');


	

	//change package status
	Route::get('package/status/change', 'packageStatusController@changepackageStatus')->name('admin.changepackageStatus');
	Route::match(['get','post'], 'change/shipping/address/{package_id}', 'ShippingMethodController@changeShippingAddress')->name('admin.changeShippingAddress');
	Route::get('package/post/status/change', 'packageStatusController@changeProductpackageStatus')->name('admin.changeProductpackageStatus');

	Route::get('package/cancel/{package_id?}', 'packageStatusController@packageCancel')->name('admin.packageCancel');
	Route::get('package/invoice/print/{package_id?}', 'PurchasePackageController@invoicePrintBy')->name('admin.invoicePrintBy');



	// refund Config route
	Route::get('refund/configuration', 'RefundReasonController@refundConfig')->name('admin.refundConfig');
	Route::post('refund/configuration/update', 'RefundReasonController@refundConfigUpdate')->name('admin.refundConfigUpdate');

	// refund reason route
	Route::get('return/package/reason', 'RefundReasonController@index')->name('returnReason');
	Route::post('return/package/reason/store', 'RefundReasonController@store')->name('returnReason.store');
	Route::get('return/package/reason/edit/{id}', 'RefundReasonController@edit')->name('returnReason.edit');
	Route::post('return/package/reason/update', 'RefundReasonController@update')->name('returnReason.update');
	Route::get('return/package/reason/delete/{id}', 'RefundReasonController@delete')->name('returnReason.delete');

	route::get('user/conversations/{username?}', 'MessageAdminController@userConversations')->name('userConversations');
	route::get('get/conversations/{username?}', 'MessageAdminController@getConversations')->name('getConversations');

	//message routes
	route::get('message/write', 'MessageAdminController@messageWrite')->name('adminMessageWrite');
	route::get('message/list/{status?}', 'MessageAdminController@adminMessage')->name('adminMessage');
	route::post('message/store/{update?}', 'MessageAdminController@adminMessageStore')->name('adminMessage.store');
	route::get('message/edit/{slug}', 'MessageAdminController@adminMessageEdit')->name('adminMessage.edit');
	route::get('message/details/{slug}/{conversation?}', 'MessageAdminController@adminMessageDetails')->name('adminMessageDetails');
	route::post('message/conversation', 'MessageAdminController@adminMessageConversation')->name('adminMessageConversation');
	route::get('message/delete/{id}', 'MessageAdminController@adminMessageDelete')->name('adminMessage.delete'); 


});



?>
